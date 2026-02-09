<?php

namespace App\Filament\Resources\ProductPlans\Pages;

use App\Filament\Resources\ProductPlans\ProductPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductPlans extends ListRecords
{
    protected static string $resource = ProductPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
