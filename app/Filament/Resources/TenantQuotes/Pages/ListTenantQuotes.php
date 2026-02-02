<?php

namespace App\Filament\Resources\TenantQuotes\Pages;

use App\Filament\Resources\TenantQuotes\TenantQuoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantQuotes extends ListRecords
{
    protected static string $resource = TenantQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
