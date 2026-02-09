<?php

namespace App\Filament\Resources\TenantBusinesses\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TenantBusinessNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('author_id')
                ->relationship('author', 'name')
                ->default(auth()->id())
                ->required(),
            TextInput::make('title')->placeholder('Summary of note'),
            Textarea::make('content')->required()->rows(4),
            Select::make('type')
                ->options([
                    'general' => 'General',
                    'follow_up' => 'Follow Up',
                    'sales' => 'Sales',
                    'support' => 'Support',
                ])->default('general'),
            DatePicker::make('follow_up_date'),
            Toggle::make('is_resolved')->label('Resolved?')->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('created_at')->dateTime()->label('Date'),
            TextColumn::make('author.name')->label('Staff'),
            TextColumn::make('type')->badge(),
            TextColumn::make('title'),
            IconColumn::make('is_resolved')->boolean()->label('Done'),
            TextColumn::make('follow_up_date')->date()->color('warning'),
        ])->headerActions([
            Tables\Actions\CreateAction::make(),
        ])->actions([
            Tables\ActionsditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }
}