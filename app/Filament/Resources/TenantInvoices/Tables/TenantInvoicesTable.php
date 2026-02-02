<?php

namespace App\Filament\Resources\TenantInvoices\Tables;

use App\Models\TenantInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantInvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
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
                        'paid' => 'success',
                        'past_due' => 'danger',
                        'void' => 'warning',
                        default => 'warning',
                    }),
                TextColumn::make('due_date')
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
                    ->action(function (TenantInvoice $record) {
                        $pdf = Pdf::loadView('pdf.invoice', [
                            'record' => $record,
                            'brandName' => '7 Hertz Studio',
                        ]);
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            "Invoice-{$record->invoice_number}.pdf"
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
