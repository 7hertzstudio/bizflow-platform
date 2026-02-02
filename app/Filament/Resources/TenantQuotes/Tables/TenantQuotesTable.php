<?php

namespace App\Filament\Resources\TenantQuotes\Tables;

use App\Models\TenantQuote;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantQuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('business.name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('total')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'info',
                        'accepted' => 'success',
                        'declined' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('valid_until')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (TenantQuote $record) {
                        $pdf = Pdf::loadView('pdf.quote', [
                            'record' => $record,
                            'brandName' => '7 Hertz Studio', // This should eventually come from the Auth User's brand or Tenant settings
                        ]);
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            "Quote-{$record->reference_number}.pdf"
                        );
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}