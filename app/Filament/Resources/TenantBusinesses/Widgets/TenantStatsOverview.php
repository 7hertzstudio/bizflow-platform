<?php

namespace App\Filament\Resources\TenantBusinesses\Widgets;

use App\Models\TenantBusiness;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class TenantStatsOverview extends StatsOverviewWidget
{
    // This allows the widget to access the record from the View page
    public ?TenantBusiness $record = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Active Domains', $this->record->domains()->count())
            ->description('Registered Domain')
            ->descriptionIcon('heroicon-m-globe-alt')
            ->color('primary'),

//            Stat::make('Total Invoiced', 'PKR ' . number_format($this->record->invoices()->sum('total_amount') / 100, 2))
//                ->description('Lifetime value')
//                ->color('success'),
//
//            Stat::make('Active Subscriptions', $this->record->subscriptions()->where('status', 'active')->count())
//                ->description('Recurring services')
//                ->color('warning'),
        ];
    }
}
