<?php

namespace App\Filament\Resources\TenantBusinesses\Pages;

use App\Filament\Resources\TenantBusinesses\TenantBusinessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantBusinesses extends ListRecords
{
    protected static string $resource = TenantBusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
