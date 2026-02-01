<?php

namespace App\Filament\Resources\TenantSubscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TenantSubscriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('tenant_business_id'),
                TextEntry::make('tenant_plan_id'),
                TextEntry::make('price_at_subscription')
                    ->numeric(),
                TextEntry::make('currency_at_subscription'),
                TextEntry::make('exchange_rate_used')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('starts_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ends_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('canceled_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
