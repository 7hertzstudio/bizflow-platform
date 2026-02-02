<?php

namespace App\Filament\Resources\DomainPricings;

use App\Filament\Resources\DomainPricings\Pages\CreateDomainPricing;
use App\Filament\Resources\DomainPricings\Pages\EditDomainPricing;
use App\Filament\Resources\DomainPricings\Pages\ListDomainPricings;
use App\Filament\Resources\DomainPricings\Schemas\DomainPricingForm;
use App\Filament\Resources\DomainPricings\Tables\DomainPricingsTable;
use App\Models\DomainPricing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DomainPricingResource extends Resource
{
    protected static ?string $model = DomainPricing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Infrastructure';

    public static function form(Schema $schema): Schema
    {
        return DomainPricingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DomainPricingsTable::configure($table);
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
            'index' => ListDomainPricings::route('/'),
            'create' => CreateDomainPricing::route('/create'),
            'edit' => EditDomainPricing::route('/{record}/edit'),
        ];
    }
}