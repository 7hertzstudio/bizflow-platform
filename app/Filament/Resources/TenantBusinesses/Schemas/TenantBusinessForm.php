<?php

namespace App\Filament\Resources\TenantBusinesses\Schemas;

use App\Models\Brand;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TenantBusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                static::getIdentitySection(),
                static::getBillingSection(),
            ]);
    }

    public static function getIdentitySection(): Section
    {
        return Section::make('Business Identity')
            ->schema([
                Grid::make(2)->schema([
                    Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->required()
                        ->default(fn() => auth()->user()->brand_id)
                        ->searchable(),
                    Select::make('owner_id')
                        ->relationship('owner', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique('users', 'email'),
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->visibleOn('create'),
                        ]),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->unique('tenant_businesses', 'slug', ignoreRecord: true),
                ]),
            ]);
    }

    public static function getBillingSection(): Section
    {
        return Section::make('Billing & Status')
            ->schema([
                Grid::make(2)->schema([
                    Select::make('billing_currency')
                        ->options([
                            'USD' => 'USD - US Dollar',
                            'PKR' => 'PKR - Pakistani Rupee',
                            'GBP' => 'GBP - British Pound',
                        ])
                        ->required()
                        ->default('USD'),
                    Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'suspended' => 'Suspended',
                            'trial' => 'Trial',
                            'archived' => 'Archived',
                        ])
                        ->required()
                        ->default('active'),
                ]),
            ]);
    }
}