<?php

namespace App\Filament\Resources\TenantDomains;

use App\Filament\Resources\TenantDomains\Pages\CreateTenantDomain;
use App\Filament\Resources\TenantDomains\Pages\EditTenantDomain;
use App\Filament\Resources\TenantDomains\Pages\ListTenantDomains;
use App\Filament\Resources\TenantDomains\Schemas\TenantDomainForm;
use App\Filament\Resources\TenantDomains\Tables\TenantDomainsTable;
use App\Models\TenantDomain;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TenantDomainResource extends Resource
{
    protected static ?string $model = TenantDomain::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static UnitEnum|string|null $navigationGroup = 'Infrastructure';

    public static function form(Schema $schema): Schema
    {
        return TenantDomainForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantDomainsTable::configure($table);
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
            'index' => ListTenantDomains::route('/'),
            'create' => CreateTenantDomain::route('/create'),
            'edit' => EditTenantDomain::route('/{record}/edit'),
        ];
    }
}