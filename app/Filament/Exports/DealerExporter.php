<?php

namespace App\Filament\Exports;

use App\Models\Dealer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class DealerExporter extends Exporter
{
    protected static ?string $model = Dealer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('first_name')->label('Vorname'),
            ExportColumn::make('last_name')->label('Nachname'),
            ExportColumn::make('email')->label('E-Mail'),
            ExportColumn::make('pin')->label('PIN'),
            ExportColumn::make('last_login_at')->label('Letzter Login'),
            ExportColumn::make('created_at')->label('Erstellt'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = Number::format($export->successful_rows) . ' Haendler erfolgreich exportiert.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' fehlgeschlagen.';
        }

        return $body;
    }
}
