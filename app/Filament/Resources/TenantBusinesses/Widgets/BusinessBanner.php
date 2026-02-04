<?php

namespace App\Filament\Resources\TenantBusinesses\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class BusinessBanner extends Widget
{
    public ?Model $record = null;

    // REMOVED 'static' keyword here
    protected string $view = 'filament.widgets.business-banner';

    protected int | string | array $columnSpan = 'full';

    protected function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
}
