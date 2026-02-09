<?php

namespace App\Filament\Resources\TenantBusinesses\Pages;

use App\Filament\Resources\TenantBusinesses\TenantBusinessResource;
use App\Models\User;
use App\Models\TenantBusiness;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateTenantBusiness extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = TenantBusinessResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Owner Account')
                ->description('Select an existing user or create a new one.')
                ->schema([
                    ToggleButtons::make('user_mode')
                        ->label('Owner Type')
                        ->options([
                            'existing' => 'Existing User',
                            'new' => 'New User',
                        ])
                        ->default('existing')
                        ->icons([
                            'existing' => 'heroicon-o-user',
                            'new' => 'heroicon-o-user-plus',
                        ])
                        ->colors([
                            'existing' => 'info',
                            'new' => 'success',
                        ])
                        ->live(),

                    Grid::make(2)
                        ->schema([
                            // Existing User Selection
                            Select::make('owner_id')
                                ->label('Select Owner')
                                ->options(User::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->visible(fn ($get) => $get('user_mode') === 'existing'),

                            // New User Creation
                            TextInput::make('user_name')
                                ->label('Full Name')
                                ->required()
                                ->visible(fn ($get) => $get('user_mode') === 'new'),
                            TextInput::make('user_email')
                                ->label('Email Address')
                                ->email()
                                ->required()
                                ->unique('users', 'email')
                                ->visible(fn ($get) => $get('user_mode') === 'new'),
                            TextInput::make('user_password')
                                ->label('Password')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->visible(fn ($get) => $get('user_mode') === 'new'),
                        ]),
                ]),

            Step::make('Business Identity')
                ->description('Enter the legal and brand details.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->required()
                            ->default(fn() => auth()->user()->brand_id)
                            ->searchable(),
                        TextInput::make('name')
                            ->label('Business Name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique('tenant_businesses', 'slug'),
                    ]),
                ]),

            Step::make('Financial Setup')
                ->description('Configure billing currency and account status.')
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
                ]),

            Step::make('Primary Address')
                ->description('Main billing and physical location.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('address_line_1')->required(),
                        TextInput::make('address_line_2'),
                        TextInput::make('city')->required(),
                        TextInput::make('state'),
                        TextInput::make('postal_code'),
                        TextInput::make('country_code')
                            ->required()
                            ->label('Country Code (ISO)')
                            ->placeholder('e.g. US, PK, GB'),
                    ]),
                ]),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $ownerId = $data['owner_id'] ?? null;

        // 1. If "New User" mode, create the user first
        if ($data['user_mode'] === 'new') {
            $user = User::create([
                'name' => $data['user_name'],
                'email' => $data['user_email'],
                'password' => Hash::make($data['user_password']),
                'brand_id' => $data['brand_id'],
            ]);
            $ownerId = $user->id;
        }

        // 2. Prepare Address Data
        $addressData = [
            'address_line_1' => $data['address_line_1'],
            'address_line_2' => $data['address_line_2'] ?? null,
            'city' => $data['city'],
            'state' => $data['state'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'country_code' => $data['country_code'],
            'type' => 'billing',
            'is_primary' => true,
        ];

        // 3. Create the Business linked to the Owner
        $business = TenantBusiness::create([
            'brand_id' => $data['brand_id'],
            'owner_id' => $ownerId,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'billing_currency' => $data['billing_currency'],
            'status' => $data['status'],
        ]);

        // 4. Create the address
        $business->addresses()->create($addressData);

        return $business;
    }
}