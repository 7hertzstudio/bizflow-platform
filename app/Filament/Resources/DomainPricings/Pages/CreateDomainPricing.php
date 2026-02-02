<?php

namespace App\Filament\Resources\DomainPricings\Pages;

use App\Filament\Resources\DomainPricings\DomainPricingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDomainPricing extends CreateRecord
{
    protected static string $resource = DomainPricingResource::class;
}