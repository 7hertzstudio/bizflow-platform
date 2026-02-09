<?php

namespace App\Filament\Resources\TenantBusinesses;

use App\Filament\Resources\TenantBusinesses\Pages\CreateTenantBusiness;
use App\Filament\Resources\TenantBusinesses\Pages\EditTenantBusiness;
use App\Filament\Resources\TenantBusinesses\Pages\ListTenantBusinesses;
use App\Filament\Resources\TenantBusinesses\Pages\ViewTenantBusiness;
use App\Filament\Resources\TenantBusinesses\Schemas\TenantBusinessForm;
use App\Filament\Resources\TenantBusinesses\Tables\TenantBusinessesTable;
use App\Models\TenantBusiness;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Table;
use UnitEnum;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;

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
            RelationManagers\TenantDomainsRelationManager::class,
            RelationManagers\TenantSubscriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenantBusinesses::route('/'),
            'create' => CreateTenantBusiness::route('/create'),
            'edit' => EditTenantBusiness::route('/{record}/edit'),
            'view' => ViewTenantBusiness::route('/{record}'),
        ];
    }


    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rate limiting')
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        // ...
                    ])
                ->columnSpan(2)
                ,

                Section::make('Rate limiting')
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        // ...
                    ])
            ])->columns([
                '2xl' => 3,
                'default' => 1,
            ]);
    }
}
