<?php

namespace App\Filament\Resources\TenantBusinesses\Pages;

use App\Filament\Resources\TenantBusinesses\TenantBusinessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantBusiness extends CreateRecord
{
    protected static string $resource = TenantBusinessResource::class;
}
