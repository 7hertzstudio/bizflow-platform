<?php

namespace App\Filament\Resources\TenantQuotes\Pages;

use App\Filament\Resources\TenantQuotes\TenantQuoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTenantQuote extends ViewRecord
{
    protected static string $resource = TenantQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
