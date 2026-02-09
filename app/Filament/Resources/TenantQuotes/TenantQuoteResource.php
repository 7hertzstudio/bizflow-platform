<?php

namespace App\Filament\Resources\TenantQuotes;

use App\Filament\Resources\TenantQuotes\Pages\CreateTenantQuote;
use App\Filament\Resources\TenantQuotes\Pages\EditTenantQuote;
use App\Filament\Resources\TenantQuotes\Pages\ListTenantQuotes;
use App\Filament\Resources\TenantQuotes\Pages\ViewTenantQuote;
use App\Filament\Resources\TenantQuotes\Schemas\TenantQuoteForm;
use App\Filament\Resources\TenantQuotes\Tables\TenantQuotesTable;
use App\Models\TenantQuote;
use BackedEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TenantQuoteResource extends Resource
{
    protected static ?string $model = TenantQuote::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static UnitEnum|string|null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return TenantQuoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantQuotesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quote Details')
                    ->schema([
                        TextEntry::make('reference_number')->weight('bold'),
                        TextEntry::make('business.name')->label('Client'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match (strtolower($state)) {
                                'draft' => 'gray',
                                'sent' => 'info',
                                'accepted' => 'success',
                                'declined' => 'danger',
                                default => 'warning',
                            }),
                        TextEntry::make('valid_until')->date(),
                        TextEntry::make('currency'),
                    ])->columns(2),

                Section::make('Line Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('description'),
                                TextEntry::make('qty'),
                                TextEntry::make('unit_price')->money(fn ($record) => $record->quote?->currency ?? 'USD'),
                                TextEntry::make('row_total')->money(fn ($record) => $record->quote?->currency ?? 'USD'),
                            ])->columns(4),
                    ]),

                Section::make('Totals')
                    ->schema([
                        TextEntry::make('subtotal')->money(fn ($record) => $record->currency),
                        TextEntry::make('discount_total')->money(fn ($record) => $record->currency)->color('danger'),
                        TextEntry::make('total')->money(fn ($record) => $record->currency)->weight('bold')->size('lg'),
                    ])->columns(3),

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
            'index' => ListTenantQuotes::route('/'),
            'create' => CreateTenantQuote::route('/create'),
            'view' => ViewTenantQuote::route('/{record}'),
            'edit' => EditTenantQuote::route('/{record}/edit'),
        ];
    }
}
