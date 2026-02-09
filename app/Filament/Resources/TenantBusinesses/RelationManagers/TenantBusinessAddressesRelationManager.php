<?php

namespace App\Filament\Resources\TenantBusinesses\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TenantBusinessAddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')
                ->options([
                    'billing' => 'Billing',
                    'physical' => 'Physical',
                    'headquarters' => 'Headquarters',
                ])->required(),
            TextInput::make('address_line_1')->required(),
            TextInput::make('address_line_2'),
            TextInput::make('city')->required(),
            TextInput::make('state'),
            TextInput::make('postal_code'),
            TextInput::make('country_code')->required()->placeholder('e.g. US, GB'),
            Toggle::make('is_primary')->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('type')->badge(),
            TextColumn::make('address_line_1'),
            TextColumn::make('city'),
            TextColumn::make('country_code')->label('Country'),
            IconColumn::make('is_primary')->boolean(),
        ])->headerActions([
            Tables\Actions\CreateAction::make(),
        ]);
    }
}