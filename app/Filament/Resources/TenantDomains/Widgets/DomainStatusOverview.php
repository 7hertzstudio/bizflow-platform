<?php

namespace App\Filament\Resources\TenantDomains\Widgets;

use App\Models\TenantBusiness;
use App\Models\TenantDomain;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DomainStatusOverview extends StatsOverviewWidget
{
    public ?TenantBusiness $record = null;

    public static function canView(): bool
    {
        // Hide on List pages unless a tenant filter is explicitly active
        return request()->has('tenant') || request()->routeIs('*.view');
    }

    protected function getStats(): array
    {
        $query = TenantDomain::query();
        $labelSuffix = '';

        if ($this->record) {
            $query->where('tenant_business_id', $this->record->id);
            $labelSuffix = " ({$this->record->name})";
        } else {
            $tenantId = request()->query('tenant');
            if ($tenantId && $tenantId !== 'all') {
                $query->where('tenant_business_id', $tenantId);
                $business = TenantBusiness::find($tenantId);
                $labelSuffix = $business ? " ({$business->name})" : "";
            } else {
                $labelSuffix = " (All)";
            }
        }

        $activeCount = (clone $query)->where('status', 'active')->count();
        $expiringSoonCount = (clone $query)
            ->where('status', 'active')
            ->where('expires_at', '<=', now()->addDays(30))
            ->where('expires_at', '>', now())
            ->count();
        $expiredCount = (clone $query)->where('status', 'expired')->count();

        return [
            Stat::make('Active Domains' . $labelSuffix, $activeCount)
                ->description('Healthy domains')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Expiring Soon' . $labelSuffix, $expiringSoonCount)
                ->description('Within 30 days')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
            Stat::make('Expired' . $labelSuffix, $expiredCount)
                ->description('Require attention')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
