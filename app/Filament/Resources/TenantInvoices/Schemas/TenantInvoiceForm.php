<?php

namespace App\Filament\Resources\TenantInvoices\Schemas;

use App\Services\FinanceCalculator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantInvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Header')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('tenant_business_id')
                                ->relationship('business', 'name')
                                ->required(),
                            TextInput::make('invoice_number')
                                ->default('INV-' . strtoupper(uniqid()))
                                ->readOnly(),
                        ]),
                        Grid::make(3)->schema([
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'sent' => 'Sent',
                                    'paid' => 'Paid',
                                    'past_due' => 'Past Due',
                                    'void' => 'Void',
                                ])
                                ->required()
                                ->default('draft'),
                            DatePicker::make('due_date'),
                            DateTimePicker::make('paid_at'),
                        ]),
                    ]),

                Section::make('Discount Configuration')
                    ->schema([
                        Toggle::make('has_master_discount')
                            ->label('Enable Master Discount')
                            ->live()
                            ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set)),
                        Grid::make(2)->schema([
                            Select::make('master_discount_type')
                                ->options([
                                    'percentage' => 'Percentage (%)',
                                    'fixed' => 'Fixed Amount',
                                ])
                                ->default('percentage')
                                ->live()
                                ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set))
                                ->hidden(fn ($get) => !$get('has_master_discount')),
                            TextInput::make('master_discount_value')
                                ->numeric()
                                ->default(0)
                                ->live(debounce: 500)
                                ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set))
                                ->hidden(fn ($get) => !$get('has_master_discount')),
                        ]),
                    ]),

                Section::make('Line Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('description')
                                        ->required()
                                        ->columnSpan(2),
                                    TextInput::make('qty')
                                        ->numeric()
                                        ->default(1)
                                        ->required()
                                        ->live(debounce: 500)
                                        ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set)),
                                    TextInput::make('unit_price')
                                        ->numeric()
                                        ->required()
                                        ->prefix('$')
                                        ->live(debounce: 500)
                                        ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set)),
                                ]),
                                Grid::make(2)->schema([
                                    Toggle::make('use_master_discount')
                                        ->label('Apply Master Discount')
                                        ->default(true)
                                        ->live()
                                        ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set)),
                                    TextInput::make('custom_discount_value')
                                        ->label('Custom Discount')
                                        ->numeric()
                                        ->live(debounce: 500)
                                        ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set))
                                        ->hidden(fn ($get) => $get('use_master_discount')),
                                ]),
                            ])
                            ->live()
                            ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set))
                            ->columns(1),
                    ]),

                Section::make('Calculations')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('subtotal')->readOnly(),
                            TextInput::make('discount_total')->readOnly(),
                            TextInput::make('rounding_adjustment')
                                ->label('Rounding (+/-)')
                                ->numeric()
                                ->default(0)
                                ->live(debounce: 500)
                                ->afterStateUpdated(fn ($get, $set) => self::updateTotals($get, $set)),
                            TextInput::make('total')->readOnly()->label('Grand Total'),
                        ]),
                    ]),
            ]);
    }

    public static function updateTotals($get, $set): void
    {
        $state = [
            'items' => $get('items'),
            'has_master_discount' => $get('has_master_discount'),
            'master_discount_type' => $get('master_discount_type'),
            'master_discount_value' => $get('master_discount_value'),
            'rounding_adjustment' => $get('rounding_adjustment'),
        ];

        $totals = FinanceCalculator::calculateTotals($state);

        $set('subtotal', $totals['subtotal']);
        $set('discount_total', $totals['discount_total']);
        $set('total', $totals['total']);
    }
}
