<?php

namespace App\Filament\Resources\ContactPersons\Pages;

use App\Filament\Resources\ContactPersons\ContactPersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactPerson extends CreateRecord
{
    protected static string $resource = ContactPersonResource::class;
}
