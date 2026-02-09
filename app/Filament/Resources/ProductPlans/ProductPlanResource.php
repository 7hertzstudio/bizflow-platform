<?php

namespace App\Filament\Resources\ProductPlans;

use App\Filament\Resources\ProductPlans\Pages\CreateProductPlan;
use App\Filament\Resources\ProductPlans\Pages\EditProductPlan;
use App\Filament\Resources\ProductPlans\Pages\ListProductPlans;
use App\Filament\Resources\ProductPlans\Schemas\ProductPlanForm;
use App\Filament\Resources\ProductPlans\Tables\ProductPlansTable;
use App\Models\ProductPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductPlanResource extends Resource
{
    protected static ?string $model = ProductPlan::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static UnitEnum|string|null $navigationGroup = 'Billing';

    public static function form(Schema $schema): Schema
    {
        return ProductPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductPlansTable::configure($table);
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
            'index' => ListProductPlans::route('/'),
            'create' => CreateProductPlan::route('/create'),
            'edit' => EditProductPlan::route('/{record}/edit'),
        ];
    }
}