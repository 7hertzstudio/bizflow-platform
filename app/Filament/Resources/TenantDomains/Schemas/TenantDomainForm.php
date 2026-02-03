<?php

namespace App\Filament\Resources\TenantDomains\Schemas;

use App\Models\DomainPricing;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TenantDomainForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Domain Information')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('tenant_business_id')
                                ->relationship('business', 'name')
                                ->required(),
                            TextInput::make('domain')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, $set, $get) => self::updatePricing($state, $set, $get)),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('registrar')
                                ->placeholder('e.g. Namecheap, Cloudflare')
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'active' => 'Active',
                                    'expired' => 'Expired',
                                    'transferring' => 'Transferring',
                                    'pending' => 'Pending',
                                ])
                                ->required()
                                ->default('active'),
                        ]),
                        Grid::make(2)->schema([
                            DatePicker::make('registered_at')
                                ->live()
                                ->afterStateUpdated(function ($state, $set) {
                                    if ($state) {
                                        $set('expires_at', Carbon::parse($state)->addYear()->format('Y-m-d'));
                                    }
                                }),
                            DatePicker::make('expires_at')
                                ->required()
                                ->minDate(fn ($get) => $get('registered_at') 
                                    ? Carbon::parse($get('registered_at'))->addYear() 
                                    : now()->addYear()
                                )
                                ->validationMessages([
                                    'min_date' => 'The expiry date must be at least one year after the registration date.',
                                ]),
                        ]),
                    ]),

                Section::make('Management & Billing')
                    ->schema([
                        Grid::make(2)->schema([
                            Toggle::make('is_managed')
                                ->label('Managed by Agency')
                                ->helperText('We pay for renewal and bill the client.')
                                ->live(),
                            Toggle::make('auto_renew')
                                ->default(true),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('cost_price')
                                ->label('Our Cost')
                                ->numeric()
                                ->prefix('$')
                                ->helperText(fn ($get) => $get('pricing_note'))
                                ->hidden(fn ($get) => !$get('is_managed')),
                            TextInput::make('sell_price')
                                ->label('Client Price')
                                ->numeric()
                                ->prefix('$')
                                ->hidden(fn ($get) => !$get('is_managed')),
                            Select::make('currency')
                                ->options([
                                    'USD' => 'USD',
                                    'PKR' => 'PKR',
                                ])
                                ->default('USD')
                                ->hidden(fn ($get) => !$get('is_managed')),
                        ]),
                    ]),

                Section::make('Technical Details')
                    ->schema([
                        Toggle::make('is_verified')
                            ->label('Domain Verified')
                            ->disabled(),
                        KeyValue::make('dns_settings')
                            ->label('DNS Records (Snapshot)')
                            ->keyLabel('Record Type')
                            ->valueLabel('Value'),
                        Textarea::make('notes')
                            ->label('Internal Notes')
                            ->rows(3),
                    ])->collapsible()->collapsed(),
            ]);
    }

    public static function updatePricing($domain, $set, $get): void
    {
        if (blank($domain)) {
            return;
        }

        $parts = explode('.', $domain);
        if (count($parts) < 2) return;

        $tld = implode('.', array_slice($parts, 1));
        
        $pricing = DomainPricing::where('tld', $tld)->first();

        if (!$pricing && count($parts) > 2) {
             $tld = implode('.', array_slice($parts, -1)); // just the last part
             $pricing = DomainPricing::where('tld', $tld)->first();
        }

        if ($pricing) {
            $set('currency', $pricing->currency);
            
            // Logic: If status is 'active', assume renewal price. If 'pending', maybe registration?
            // For now, let's default to RENEW price for sell, and RENEW cost for us.
            // But if it's a new domain purchase, it might be register price.
            // Since this is "Domain Management" (mostly existing), renewal is safer default.
            
            $set('sell_price', $pricing->renew_price);
            
            // Use the new cost field from DB, fallback to sell price if not set
            $set('cost_price', $pricing->renew_cost > 0 ? $pricing->renew_cost : $pricing->renew_price);
        }
    }
}
