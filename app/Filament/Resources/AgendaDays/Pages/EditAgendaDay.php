<?php

namespace App\Filament\Resources\AgendaDays\Pages;

use App\Filament\Resources\AgendaDays\AgendaDayResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAgendaDay extends EditRecord
{
    protected static string $resource = AgendaDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
