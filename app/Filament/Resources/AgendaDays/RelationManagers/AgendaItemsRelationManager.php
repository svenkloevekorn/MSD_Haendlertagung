<?php

namespace App\Filament\Resources\AgendaDays\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgendaItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Programmpunkte';

    protected static ?string $modelLabel = 'Programmpunkt';

    protected static ?string $pluralModelLabel = 'Programmpunkte';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('overline')
                    ->label('Overline')
                    ->placeholder('z.B. 19:00 Uhr, Nachmittag, ab 08:00 Uhr'),
                TextInput::make('title')
                    ->label('Titel')
                    ->required(),
                Textarea::make('description')
                    ->label('Beschreibung')
                    ->rows(2)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Reihenfolge')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('overline')
                    ->label('Overline'),
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Beschreibung')
                    ->limit(40),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
