<?php

namespace App\Filament\Resources\DomainPricings\Pages;

use App\Filament\Resources\DomainPricings\DomainPricingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDomainPricing extends EditRecord
{
    protected static string $resource = DomainPricingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}