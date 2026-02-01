<?php

namespace App\Filament\Resources\TenantBusinesses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenantBusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('billing_currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('country'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
