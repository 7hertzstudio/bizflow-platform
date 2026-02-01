<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('email')
                                ->email(),
                            TextInput::make('phone')
                                ->tel(),
                            TextInput::make('website')
                                ->url(),
                        ]),
                        FileUpload::make('logo')
                            ->image()
                            ->directory('brands/logos'),
                    ]),

                Section::make('Address')
                    ->schema([
                        TextInput::make('address_line_1'),
                        TextInput::make('address_line_2'),
                        Grid::make(2)->schema([
                            TextInput::make('city'),
                            TextInput::make('state'),
                            TextInput::make('zip'),
                            TextInput::make('country'),
                        ]),
                    ])->collapsible(),

                Section::make('Finance & Billing')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('tax_id')
                                ->label('Tax ID / VAT Number'),
                            TextInput::make('currency')
                                ->default('USD')
                                ->required(),
                        ]),
                        KeyValue::make('bank_details')
                            ->label('Bank Account Details')
                            ->keyLabel('Field (e.g., Bank Name, IBAN)')
                            ->valueLabel('Value')
                            ->reorderable(),
                    ])->collapsible(),
            ]);
    }
}
