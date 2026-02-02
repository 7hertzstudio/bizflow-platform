<?php

namespace App\Filament\Resources\TenantQuotes\Pages;

use App\Filament\Resources\TenantQuotes\TenantQuoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantQuote extends CreateRecord
{
    protected static string $resource = TenantQuoteResource::class;
}
