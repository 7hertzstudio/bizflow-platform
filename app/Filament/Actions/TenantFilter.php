<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;

class TenantFilter extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'tenantFilter';
        
        return parent::make($name)
            ->view('filament.actions.tenant-filter');
    }
}
