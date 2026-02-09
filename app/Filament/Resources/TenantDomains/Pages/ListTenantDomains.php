<?php

namespace App\Filament\Resources\TenantDomains\Pages;

use App\Filament\Resources\TenantDomains\TenantDomainResource;
use App\Filament\Traits\HasTenantFilter;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListTenantDomains extends ListRecords
{
    use HasTenantFilter;

    protected static string $resource = TenantDomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getTenantFilterAction(),
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\TenantDomains\Widgets\DomainStatusOverview::class,
        ];
    }

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return parent::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $this->applyTenantFilter($query));
    }
}
