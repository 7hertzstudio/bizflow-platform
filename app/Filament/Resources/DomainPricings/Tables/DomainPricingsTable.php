<?php

namespace App\Filament\Resources\DomainPricings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DomainPricingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tld')
                    ->label('TLD')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->prefix('.'),
                TextColumn::make('register_price')
                    ->label('Register')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('renew_price')
                    ->label('Renew')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('transfer_price')
                    ->label('Transfer')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('min_years')
                    ->label('Min Years')
                    ->alignCenter(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
