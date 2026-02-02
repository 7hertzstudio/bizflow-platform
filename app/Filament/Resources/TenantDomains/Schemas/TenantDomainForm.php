<?php

namespace App\Filament\Resources\TenantDomains\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantDomainForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Domain Information')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('tenant_business_id')
                                ->relationship('business', 'name')
                                ->required(),
                            TextInput::make('domain')
                                ->required()
                                ->unique(ignoreRecord: true),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('registrar')
                                ->placeholder('e.g. Namecheap, Cloudflare')
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'active' => 'Active',
                                    'expired' => 'Expired',
                                    'transferring' => 'Transferring',
                                    'pending' => 'Pending',
                                ])
                                ->required()
                                ->default('active'),
                        ]),
                        Grid::make(2)->schema([
                            DatePicker::make('registered_at'),
                            DatePicker::make('expires_at')
                                ->required(),
                        ]),
                    ]),

                Section::make('Management & Billing')
                    ->schema([
                        Grid::make(2)->schema([
                            Toggle::make('is_managed')
                                ->label('Managed by Agency')
                                ->helperText('We pay for renewal and bill the client.')
                                ->live(),
                            Toggle::make('auto_renew')
                                ->default(true),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('cost_price')
                                ->label('Our Cost')
                                ->numeric()
                                ->prefix('$')
                                ->hidden(fn ($get) => !$get('is_managed')),
                            TextInput::make('sell_price')
                                ->label('Client Price')
                                ->numeric()
                                ->prefix('$')
                                ->hidden(fn ($get) => !$get('is_managed')),
                            Select::make('currency')
                                ->options([
                                    'USD' => 'USD',
                                    'PKR' => 'PKR',
                                ])
                                ->default('USD')
                                ->hidden(fn ($get) => !$get('is_managed')),
                        ]),
                    ]),

                Section::make('Technical Details')
                    ->schema([
                        Toggle::make('is_verified')
                            ->label('Domain Verified')
                            ->disabled(),
                        KeyValue::make('dns_settings')
                            ->label('DNS Records (Snapshot)')
                            ->keyLabel('Record Type')
                            ->valueLabel('Value'),
                        Textarea::make('notes')
                            ->label('Internal Notes')
                            ->rows(3),
                    ])->collapsible()->collapsed(),
            ]);
    }
}