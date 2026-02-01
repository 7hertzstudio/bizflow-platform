<?php

namespace App\Filament\Resources\TenantSubscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenantSubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tenant_business_id')
                    ->required(),
                TextInput::make('tenant_plan_id')
                    ->required(),
                TextInput::make('price_at_subscription')
                    ->required()
                    ->numeric(),
                TextInput::make('currency_at_subscription')
                    ->required(),
                TextInput::make('exchange_rate_used')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                DateTimePicker::make('canceled_at'),
            ]);
    }
}
