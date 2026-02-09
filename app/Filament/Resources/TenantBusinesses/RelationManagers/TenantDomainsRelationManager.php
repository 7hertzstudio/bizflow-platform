<?php

namespace App\Filament\Resources\TenantBusinesses\RelationManagers;

use App\Filament\Resources\TenantDomains\Schemas\TenantDomainForm;
use App\Filament\Resources\TenantDomains\Tables\TenantDomainsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TenantDomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'domains'; // Relationship on TenantBusiness model

    protected static ?string $recordTitleAttribute = 'domain';

    public function form(Schema $schema): Schema
    {
        return TenantDomainForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return TenantDomainsTable::configure($table)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['tenant_business_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    }),
            ]);
    }
}
