<?php

namespace App\Filament\Resources\ProductPlans\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('product_id')
                                ->relationship('product', 'name')
                                ->required()
                                ->searchable(),
                            TextInput::make('name')
                                ->required(),
                        ]),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('published'),
                    ]),

                Section::make('Pricing (Cents)')
                    ->description('All prices should be entered in cents (e.g., 5000 for $50.00).')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('price_monthly')
                                ->label('Monthly Price')
                                ->numeric()
                                ->default(0),
                            TextInput::make('compare_at_price_monthly')
                                ->label('Monthly Compare At (Strikethrough)')
                                ->numeric(),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('price_yearly')
                                ->label('Yearly Price (Total)')
                                ->numeric()
                                ->default(0),
                            TextInput::make('compare_at_price_yearly')
                                ->label('Yearly Compare At (Total)')
                                ->numeric(),
                        ]),
                        Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'PKR' => 'PKR',
                            ])
                            ->required()
                            ->default('USD'),
                        Toggle::make('is_custom')
                            ->label('Custom Deal')
                            ->default(false),
                    ]),

                Section::make('Features')
                    ->schema([
                        KeyValue::make('features')
                            ->reorderable(),
                    ])->collapsible(),
            ]);
    }
}
