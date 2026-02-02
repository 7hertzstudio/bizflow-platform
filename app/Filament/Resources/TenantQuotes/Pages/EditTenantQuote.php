<?php

namespace App\Filament\Resources\TenantQuotes\Pages;

use App\Filament\Resources\TenantQuotes\TenantQuoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantQuote extends EditRecord
{
    protected static string $resource = TenantQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
