<?php

namespace App\Filament\Resources\DomainPricings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DomainPricingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('TLD & Rules')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('tld')
                                ->label('TLD (e.g. .com)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->prefix('.'),
                            TextInput::make('min_years')
                                ->label('Min Years')
                                ->numeric()
                                ->default(1)
                                ->required(),
                            TextInput::make('max_years')
                                ->label('Max Years')
                                ->numeric()
                                ->default(10)
                                ->required(),
                        ]),
                    ]),

                Section::make('Pricing')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('currency')
                                ->options([
                                    'USD' => 'USD',
                                    'PKR' => 'PKR',
                                ])
                                ->required()
                                ->default('USD'),
                            Toggle::make('is_active')
                                ->label('Available for Purchase')
                                ->default(true),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('register_price')
                                ->label('Registration Price')
                                ->numeric()
                                ->prefix('$') // Should be dynamic based on currency, but prefix is static in Schema builder usually
                                ->required(),
                            TextInput::make('renew_price')
                                ->label('Renewal Price')
                                ->numeric()
                                ->prefix('$')
                                ->required(),
                            TextInput::make('transfer_price')
                                ->label('Transfer Price')
                                ->numeric()
                                ->prefix('$')
                                ->required(),
                        ]),
                    ]),
            ]);
    }
}
