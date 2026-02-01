<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\TenantBusiness;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegisterBusiness extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Business';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique('tenant_businesses', 'slug'),
                Select::make('country')
                    ->options([
                        'PK' => 'Pakistan',
                        'US' => 'United States',
                        'UK' => 'United Kingdom',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn ($state, $set) => $set('billing_currency', $state === 'PK' ? 'PKR' : 'USD')),
                Select::make('billing_currency')
                    ->options([
                        'PKR' => 'Pakistani Rupee (PKR)',
                        'USD' => 'US Dollar (USD)',
                    ])
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): TenantBusiness
    {
        $business = TenantBusiness::create([
            ...$data,
            'owner_id' => auth()->id(),
        ]);

        $business->users()->attach(auth()->user(), ['role' => 'tenant_admin']);

        return $business;
    }
}
