<?php

namespace App\Filament\Resources\DomainPricings\Pages;

use App\Filament\Resources\DomainPricings\DomainPricingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDomainPricings extends ListRecords
{
    protected static string $resource = DomainPricingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}