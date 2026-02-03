<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Details')
                    ->schema([
                        TextEntry::make('description'),
                        TextEntry::make('subject_type')
                            ->label('Subject Type'),
                        TextEntry::make('subject_id')
                            ->label('Subject ID'),
                        TextEntry::make('causer.name')
                            ->label('Causer'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])->columns(2),
                Section::make('Changes')
                    ->schema([
                        KeyValueEntry::make('properties')
                            ->label('Properties'),
                    ])
                    ->visible(fn ($record) => ! empty($record->properties)),
            ]);
    }
}
