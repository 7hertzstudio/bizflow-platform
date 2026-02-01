<?php

namespace App\Filament\Resources\TenantBusinesses;

use App\Filament\Resources\TenantBusinesses\Pages\CreateTenantBusiness;
use App\Filament\Resources\TenantBusinesses\Pages\EditTenantBusiness;
use App\Filament\Resources\TenantBusinesses\Pages\ListTenantBusinesses;
use App\Filament\Resources\TenantBusinesses\Schemas\TenantBusinessForm;
use App\Filament\Resources\TenantBusinesses\Tables\TenantBusinessesTable;
use App\Models\TenantBusiness;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TenantBusinessResource extends Resource
{
    protected static ?string $model = TenantBusiness::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Tenancy';

    public static function form(Schema $schema): Schema
    {
        return TenantBusinessForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantBusinessesTable::configure($table);
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
            'index' => ListTenantBusinesses::route('/'),
            'create' => CreateTenantBusiness::route('/create'),
            'edit' => EditTenantBusiness::route('/{record}/edit'),
        ];
    }
}