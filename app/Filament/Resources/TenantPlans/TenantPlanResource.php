<?php

namespace App\Filament\Resources\TenantPlans;

use App\Filament\Resources\TenantPlans\Pages\CreateTenantPlan;
use App\Filament\Resources\TenantPlans\Pages\EditTenantPlan;
use App\Filament\Resources\TenantPlans\Pages\ListTenantPlans;
use App\Filament\Resources\TenantPlans\Schemas\TenantPlanForm;
use App\Filament\Resources\TenantPlans\Tables\TenantPlansTable;
use App\Models\TenantPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TenantPlanResource extends Resource
{
    protected static ?string $model = TenantPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Billing';

    public static function form(Schema $schema): Schema
    {
        return TenantPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenantPlans::route('/'),
            'create' => CreateTenantPlan::route('/create'),
            'edit' => EditTenantPlan::route('/{record}/edit'),
        ];
    }
}