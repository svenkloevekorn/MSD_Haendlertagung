<?php

namespace App\Filament\Resources\ContactPersons\Pages;

use App\Filament\Resources\ContactPersons\ContactPersonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactPersons extends ListRecords
{
    protected static string $resource = ContactPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
