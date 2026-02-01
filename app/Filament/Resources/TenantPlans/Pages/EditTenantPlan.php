<?php

namespace App\Filament\Resources\TenantPlans\Pages;

use App\Filament\Resources\TenantPlans\TenantPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantPlan extends EditRecord
{
    protected static string $resource = TenantPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
