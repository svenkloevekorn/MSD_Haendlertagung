<?php

namespace App\Filament\Resources\ContactPersons\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactPersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('position')
                    ->label('Position / Department'),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
                TextInput::make('phone')
                    ->label('Phone (display)')
                    ->placeholder('e.g. +49 (0) 123 456 789'),
                TextInput::make('phone_link')
                    ->label('Phone (link)')
                    ->placeholder('e.g. +49123456789'),
                FileUpload::make('image_path')
                    ->label('Photo')
                    ->disk('local')
                    ->directory('contact-persons')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'live' => 'Live',
                    ])
                    ->default('draft')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
