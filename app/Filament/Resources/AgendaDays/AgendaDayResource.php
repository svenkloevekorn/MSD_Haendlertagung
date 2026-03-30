<?php

namespace App\Filament\Resources\AgendaDays;

use App\Filament\Resources\AgendaDays\Pages\CreateAgendaDay;
use App\Filament\Resources\AgendaDays\Pages\EditAgendaDay;
use App\Filament\Resources\AgendaDays\Pages\ListAgendaDays;
use App\Filament\Resources\AgendaDays\RelationManagers\AgendaItemsRelationManager;
use App\Filament\Resources\AgendaDays\Schemas\AgendaDayForm;
use App\Filament\Resources\AgendaDays\Tables\AgendaDaysTable;
use App\Models\AgendaDay;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AgendaDayResource extends Resource
{
    protected static ?string $model = AgendaDay::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Agenda';

    protected static ?string $modelLabel = 'Agenda-Tag';

    protected static ?string $pluralModelLabel = 'Agenda-Tage';

    public static function form(Schema $schema): Schema
    {
        return AgendaDayForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgendaDaysTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AgendaItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAgendaDays::route('/'),
            'create' => CreateAgendaDay::route('/create'),
            'edit' => EditAgendaDay::route('/{record}/edit'),
        ];
    }
}
