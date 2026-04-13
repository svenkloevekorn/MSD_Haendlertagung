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
            ExportColumn::make('salutation')->label('Salutation'),
            ExportColumn::make('first_name')->label('First Name'),
            ExportColumn::make('last_name')->label('Last Name'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('country')->label('Country'),
            ExportColumn::make('is_internal')->label('Internal'),
            ExportColumn::make('pin')->label('PIN'),
            ExportColumn::make('last_login_at')->label('Last Login'),
            ExportColumn::make('created_at')->label('Created'),
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
