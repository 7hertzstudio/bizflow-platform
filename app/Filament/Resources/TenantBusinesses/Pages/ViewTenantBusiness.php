<?php

namespace App\Filament\Resources\TenantBusinesses\Pages;

use App\Filament\Resources\TenantBusinesses\TenantBusinessResource;
use App\Filament\Resources\TenantBusinesses\Widgets\BusinessBanner;
use App\Filament\Resources\TenantBusinesses\Widgets\TenantStatsOverview;
use Filament\Resources\Pages\ViewRecord;

class ViewTenantBusiness extends ViewRecord
{

    protected static string $resource = TenantBusinessResource::class;

    public function getTitle(): string
    {
        return "{$this->record->name} Overview";
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getHeading(): string
    {
        return ''; // This hides the default large text under the breadcrumbs
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BusinessBanner::class,
            TenantStatsOverview::class,
            \App\Filament\Resources\TenantDomains\Widgets\DomainStatusOverview::class,
        ];
    }

    // This ensures the record ID is passed into the widget
    protected function getHeaderWidgetsData(): array
    {
        return [
            'record' => $this->record,
        ];
    }


}
