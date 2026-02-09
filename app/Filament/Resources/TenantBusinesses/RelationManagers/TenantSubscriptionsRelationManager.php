<?php

namespace App\Filament\Resources\TenantBusinesses\RelationManagers;

use App\Filament\Resources\TenantSubscriptions\Schemas\TenantSubscriptionForm;
use App\Filament\Resources\TenantSubscriptions\Tables\TenantSubscriptionsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TenantSubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions'; // Relationship on TenantBusiness model

    protected static ?string $recordTitleAttribute = 'id'; // Or a more descriptive field if available

    public function form(Schema $schema): Schema
    {
        return TenantSubscriptionForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return TenantSubscriptionsTable::configure($table)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['tenant_business_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    }),
            ]);
    }
}
