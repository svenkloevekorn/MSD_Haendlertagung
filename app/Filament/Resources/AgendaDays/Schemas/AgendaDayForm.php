<?php

namespace App\Filament\Resources\AgendaDays\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AgendaDayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('tab_label')
                    ->label('Tab-Label')
                    ->placeholder('z.B. Mo, 28.06.')
                    ->required(),
                DatePicker::make('date')
                    ->label('Datum')
                    ->required(),
                TextInput::make('title')
                    ->label('Titel')
                    ->placeholder('z.B. Montag – Anreisetag')
                    ->required(),
                TextInput::make('subtitle')
                    ->label('Untertitel')
                    ->placeholder('z.B. 28. Juni 2026'),
                TextInput::make('sort_order')
                    ->label('Reihenfolge')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
