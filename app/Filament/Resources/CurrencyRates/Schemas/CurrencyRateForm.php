<?php

namespace App\Filament\Resources\CurrencyRates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CurrencyRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    TextInput::make('from_currency')
                        ->required()
                        ->placeholder('USD')
                        ->maxLength(3),
                    TextInput::make('to_currency')
                        ->required()
                        ->placeholder('PKR')
                        ->maxLength(3),
                    TextInput::make('rate')
                        ->required()
                        ->numeric()
                        ->step(0.000001),
                ]),
            ]);
    }
}