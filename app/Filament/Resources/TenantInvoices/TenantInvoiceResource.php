<?php

namespace App\Filament\Resources\TenantInvoices;

use App\Filament\Resources\TenantInvoices\Pages\CreateTenantInvoice;
use App\Filament\Resources\TenantInvoices\Pages\EditTenantInvoice;
use App\Filament\Resources\TenantInvoices\Pages\ListTenantInvoices;
use App\Filament\Resources\TenantInvoices\Pages\ViewTenantInvoice;
use App\Filament\Resources\TenantInvoices\Schemas\TenantInvoiceForm;
use App\Filament\Resources\TenantInvoices\Tables\TenantInvoicesTable;
use App\Models\TenantInvoice;
use BackedEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TenantInvoiceResource extends Resource
{
    protected static ?string $model = TenantInvoice::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;

    protected static UnitEnum|string|null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return TenantInvoiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantInvoicesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Details')
                    ->schema([
                        TextEntry::make('invoice_number')->weight('bold'),
                        TextEntry::make('business.name')->label('Client'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match (strtolower($state)) {
                                'draft' => 'gray',
                                'sent' => 'info',
                                'paid' => 'success',
                                'past_due' => 'danger',
                                'void' => 'warning',
                                default => 'warning',
                            }),
                        TextEntry::make('due_date')->date(),
                        TextEntry::make('paid_at')->dateTime(),
                        TextEntry::make('currency'),
                    ])->columns(2),

                Section::make('Line Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('description'),
                                TextEntry::make('qty'),
                                TextEntry::make('unit_price')->money(fn ($record) => $record->invoice?->currency ?? 'USD'),
                                TextEntry::make('row_total')->money(fn ($record) => $record->invoice?->currency ?? 'USD'),
                            ])->columns(4),
                    ]),

                Section::make('Totals')
                    ->schema([
                        TextEntry::make('subtotal')->money(fn ($record) => $record->currency),
                        TextEntry::make('discount_total')->money(fn ($record) => $record->currency)->color('danger'),
                        TextEntry::make('rounding_adjustment')->money(fn ($record) => $record->currency),
                        TextEntry::make('total')->money(fn ($record) => $record->currency)->weight('bold')->size('lg'),
                    ])->columns(4),
                
                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')->markdown(),
                    ])->visible(fn ($record) => !empty($record->notes)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenantInvoices::route('/'),
            'create' => CreateTenantInvoice::route('/create'),
            'view' => ViewTenantInvoice::route('/{record}'),
            'edit' => EditTenantInvoice::route('/{record}/edit'),
        ];
    }
}
