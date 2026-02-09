<?php

namespace App\Filament\Traits;

use App\Filament\Actions\TenantFilter;
use App\Models\TenantBusiness;
use Illuminate\Database\Eloquent\Builder;

trait HasTenantFilter
{
    protected function getTenantFilterAction(): TenantFilter
    {
        return TenantFilter::make();
    }

    protected function applyTenantFilter(Builder $query): Builder
    {
        $tenantId = request()->query('tenant');
        
        if ($tenantId && $tenantId !== 'all') {
            $query->where('tenant_business_id', $tenantId);
        }

        return $query;
    }

    public function getTitle(): string
    {
        $tenantId = request()->query('tenant');

        if ($tenantId === 'all') {
            return "All {$this->getResource()::getPluralModelLabel()}";
        }

        if ($tenantId) {
            $business = TenantBusiness::find($tenantId);
            if ($business) {
                return "{$this->getResource()::getPluralModelLabel()} for {$business->name}";
            }
        }

        return parent::getTitle();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($tenantId = request()->query('tenant')) {
            $data['tenant_business_id'] = $tenantId;
        }

        return $data;
    }
}
