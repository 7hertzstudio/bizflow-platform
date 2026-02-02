<?php

namespace App\Filament\App\Resources\TenantDomains;

use App\Filament\App\Resources\TenantDomains\Pages\CreateTenantDomain;
use App\Filament\App\Resources\TenantDomains\Pages\EditTenantDomain;
use App\Filament\App\Resources\TenantDomains\Pages\ListTenantDomains;
use App\Filament\App\Resources\TenantDomains\Schemas\TenantDomainForm;
use App\Filament\App\Resources\TenantDomains\Tables\TenantDomainsTable;
use App\Models\TenantDomain;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TenantDomainResource extends Resource
{
    protected static ?string $model = TenantDomain::class;

    protected static ?string $tenantRelationship = 'business';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

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