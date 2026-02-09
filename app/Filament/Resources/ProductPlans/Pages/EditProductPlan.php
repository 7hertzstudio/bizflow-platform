<?php

namespace App\Filament\Resources\ProductPlans\Pages;

use App\Filament\Resources\ProductPlans\ProductPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductPlan extends EditRecord
{
    protected static string $resource = ProductPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
