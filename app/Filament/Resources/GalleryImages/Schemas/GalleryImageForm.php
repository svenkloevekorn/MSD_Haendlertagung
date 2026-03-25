<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titel'),
                Textarea::make('description')
                    ->label('Beschreibung')
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->label('Bild')
                    ->disk('local')
                    ->directory('gallery')
                    ->image()
                    ->imageResizeMode('cover')
                    ->maxSize(10240) // 10 MB
                    ->required()
                    ->storeFileNamesIn('original_filename')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Entwurf',
                        'live' => 'Live',
                    ])
                    ->default('draft')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Reihenfolge')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
