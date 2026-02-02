<?php

namespace App\Filament\App\Resources\TenantDomains\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantDomainForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Domain Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('domain')
                                ->label('Domain Name')
                                ->placeholder('example.com')
                                ->required()
                                ->unique(ignoreRecord: true),
                            TextInput::make('registrar')
                                ->label('Registrar')
                                ->placeholder('e.g., Namecheap')
                                ->helperText('If not managed by us, tell us where it is registered.')
                                ->disabled(fn ($record) => $record?->is_managed),
                        ]),
                        Grid::make(2)->schema([
                            DatePicker::make('expires_at')
                                ->label('Expiration Date')
                                ->disabled(fn ($record) => $record?->is_managed),
                            Toggle::make('auto_renew')
                                ->label('Enable Auto-Renewal')
                                ->helperText('If managed by us, we will automatically renew this domain.'),
                        ]),
                    ]),

                Section::make('Billing Status')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('sell_price')
                                ->label('Renewal Price')
                                ->numeric()
                                ->prefix(fn ($record) => match($record?->currency) {
                                    'PKR' => 'Rs.',
                                    'EUR' => '€',
                                    'GBP' => '£',
                                    default => '$',
                                })
                                ->disabled()
                                ->visible(fn ($record) => $record?->is_managed),
                            Toggle::make('is_managed')
                                ->label('Managed by Agency')
                                ->disabled()
                                ->helperText('Indicates if the agency manages the billing for this domain.'),
                        ]),
                    ])->visible(fn ($record) => $record?->is_managed),
            ]);
    }
}
