<?php

namespace App\Filament\App\Resources\TenantDomains\Pages;

use App\Filament\App\Resources\TenantDomains\TenantDomainResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantDomain extends EditRecord
{
    protected static string $resource = TenantDomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
