<?php

namespace App\Filament\App\Resources\TenantDomains\Pages;

use App\Filament\App\Resources\TenantDomains\TenantDomainResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantDomain extends CreateRecord
{
    protected static string $resource = TenantDomainResource::class;
}
