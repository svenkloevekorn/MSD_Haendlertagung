<?php

namespace App\Filament\Imports;

use App\Models\Dealer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class DealerImporter extends Importer
{
    protected static ?string $model = Dealer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name')
                ->label('Vorname')
                ->requiredMapping()
                ->rules(['required', 'string']),
            ImportColumn::make('last_name')
                ->label('Nachname')
                ->requiredMapping()
                ->rules(['required', 'string']),
            ImportColumn::make('email')
                ->label('E-Mail')
                ->requiredMapping()
                ->rules(['required', 'email']),
            ImportColumn::make('pin')
                ->label('PIN')
                ->requiredMapping()
                ->rules(['required', 'string', 'size:6']),
        ];
    }

    public function resolveRecord(): ?Dealer
    {
        // Wenn E-Mail existiert → Update, sonst neu anlegen
        return Dealer::firstOrNew(['email' => $this->data['email']]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = Number::format($import->successful_rows) . ' Haendler erfolgreich importiert/aktualisiert.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' fehlgeschlagen.';
        }

        return $body;
    }
}
