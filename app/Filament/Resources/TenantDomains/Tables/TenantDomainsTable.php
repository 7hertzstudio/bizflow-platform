<?php

namespace App\Filament\Resources\TenantDomains\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TenantDomainsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('domain_name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('business.name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('registrar')
                    ->badge(),
                TextColumn::make('expiry_date')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->expires_at && $record->expires_at->isPast() ? 'danger' : ($record->expires_at && $record->expires_at->diffInDays(now()) < 30 ? 'warning' : 'success')),
                IconColumn::make('is_managed_by_us')
                    ->label('Managed')
                    ->boolean(),
                IconColumn::make('auto_renew')
                    ->boolean(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'danger',
                        'transferring' => 'warning',
                        'pending' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('business')
                    ->relationship('business', 'name')
                    ->searchable()
                    ->preload()
                    ->default(request()->query('tenant')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}