<?php

namespace App\Filament\Resources\TenantPlans\Pages;

use App\Filament\Resources\TenantPlans\TenantPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantPlan extends CreateRecord
{
    protected static string $resource = TenantPlanResource::class;
}
