<?php

namespace App\Filament\Resources\Dealers\Pages;

use App\Filament\Exports\DealerExporter;
use App\Filament\Imports\DealerImporter;
use App\Filament\Resources\Dealers\DealerResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListDealers extends ListRecords
{
    protected static string $resource = DealerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(DealerImporter::class)
                ->label('Import'),
            ExportAction::make()
                ->exporter(DealerExporter::class)
                ->label('Export'),
            CreateAction::make(),
        ];
    }
}
