<?php

namespace App\Filament\Resources\AgendaDays\Pages;

use App\Filament\Resources\AgendaDays\AgendaDayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgendaDays extends ListRecords
{
    protected static string $resource = AgendaDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
