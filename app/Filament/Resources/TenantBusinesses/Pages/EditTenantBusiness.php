<?php

namespace App\Filament\Resources\TenantBusinesses\Pages;

use App\Filament\Resources\TenantBusinesses\TenantBusinessResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantBusiness extends EditRecord
{
    protected static string $resource = TenantBusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
