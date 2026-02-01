<?php

namespace App\Filament\Resources\TenantPlans\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Basics')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('brand_id')
                                ->relationship('brand', 'name')
                                ->required(),
                            TextInput::make('name')
                                ->required(),
                        ]),
                        Grid::make(2)->schema([
                            Select::make('category')
                                ->options([
                                    'hosting' => 'Web Hosting',
                                    'pos' => 'POS System',
                                    'development' => 'Software Development',
                                    'bundle' => 'Service Bundle',
                                    'marketing' => 'Marketing Services',
                                ])
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'archived' => 'Archived',
                                ])
                                ->required()
                                ->default('published'),
                        ]),
                    ]),

                Section::make('Pricing')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('base_price')
                                ->required()
                                ->numeric(),
                            Select::make('base_currency')
                                ->options([
                                    'USD' => 'US Dollar (USD)',
                                    'PKR' => 'Pakistani Rupee (PKR)',
                                ])
                                ->required()
                                ->default('USD'),
                        ]),
                        Toggle::make('is_custom')
                            ->label('Bespoke/Custom Plan')
                            ->helperText('Custom plans are hidden from public signup and used for specific clients.'),
                    ]),

                Section::make('Features')
                    ->schema([
                        KeyValue::make('features')
                            ->keyLabel('Feature Name')
                            ->valueLabel('Value/Description')
                            ->reorderable(),
                    ])->collapsible(),
            ]);
    }
}