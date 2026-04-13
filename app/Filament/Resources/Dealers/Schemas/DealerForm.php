<?php

namespace App\Filament\Resources\Dealers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DealerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Vorname')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Nachname')
                    ->required(),
                TextInput::make('email')
                    ->label('E-Mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('salutation')
                    ->label('Salutation')
                    ->placeholder('e.g. Mr., Mrs., Dr.'),
                TextInput::make('country')
                    ->label('Country'),
                TextInput::make('pin')
                    ->label('PIN (6-stellig)')
                    ->required()
                    ->minLength(6)
                    ->maxLength(6)
                    ->alphaNum()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => strtoupper(substr(bin2hex(random_bytes(3)), 0, 6)))
                    ->helperText('6-stelliger Zugangscode (Buchstaben + Zahlen). Wird automatisch in Grossbuchstaben gespeichert.'),
                Toggle::make('is_internal')
                    ->label('Internal')
                    ->helperText('Internal dealers are excluded from statistics and have no form obligations.')
                    ->default(false),
            ]);
    }
}
