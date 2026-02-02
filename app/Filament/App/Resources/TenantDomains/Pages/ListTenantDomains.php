<?php

namespace App\Filament\App\Resources\TenantDomains\Pages;

use App\Filament\App\Resources\TenantDomains\TenantDomainResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantDomains extends ListRecords
{
    protected static string $resource = TenantDomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
