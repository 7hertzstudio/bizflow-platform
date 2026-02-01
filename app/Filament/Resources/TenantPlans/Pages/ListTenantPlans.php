<?php

namespace App\Filament\Resources\TenantPlans\Pages;

use App\Filament\Resources\TenantPlans\TenantPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantPlans extends ListRecords
{
    protected static string $resource = TenantPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
