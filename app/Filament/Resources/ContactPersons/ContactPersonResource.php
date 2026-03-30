<?php

namespace App\Filament\Resources\ContactPersons;

use App\Filament\Resources\ContactPersons\Pages\CreateContactPerson;
use App\Filament\Resources\ContactPersons\Pages\EditContactPerson;
use App\Filament\Resources\ContactPersons\Pages\ListContactPersons;
use App\Filament\Resources\ContactPersons\Schemas\ContactPersonForm;
use App\Filament\Resources\ContactPersons\Tables\ContactPersonsTable;
use App\Models\ContactPerson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactPersonResource extends Resource
{
    protected static ?string $model = ContactPerson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Contact Persons';

    protected static ?string $modelLabel = 'Contact Person';

    protected static ?string $pluralModelLabel = 'Contact Persons';

    public static function form(Schema $schema): Schema
    {
        return ContactPersonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactPersonsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactPersons::route('/'),
            'create' => CreateContactPerson::route('/create'),
            'edit' => EditContactPerson::route('/{record}/edit'),
        ];
    }
}
