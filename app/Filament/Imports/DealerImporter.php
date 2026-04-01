<?php

namespace App\Filament\Imports;

use App\Models\Dealer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class DealerImporter extends Importer
{
    protected static ?string $model = Dealer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('salutation')
                ->label('Salutation')
                ->rules(['nullable', 'string']),
            ImportColumn::make('first_name')
                ->label('First Name')
                ->requiredMapping()
                ->rules(['required', 'string']),
            ImportColumn::make('last_name')
                ->label('Last Name')
                ->requiredMapping()
                ->rules(['required', 'string']),
            ImportColumn::make('email')
                ->label('Email')
                ->requiredMapping()
                ->rules(['required', 'email']),
            ImportColumn::make('country')
                ->label('Country')
                ->rules(['nullable', 'string']),
            ImportColumn::make('pin')
                ->label('PIN')
                ->rules(['nullable', 'string', 'max:6']),
        ];
    }

    public function resolveRecord(): ?Dealer
    {
        return Dealer::firstOrNew(['email' => $this->data['email']]);
    }

    public function beforeSave(): void
    {
        if (empty($this->record->pin)) {
            do {
                $pin = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            } while (Dealer::where('pin', $pin)->exists());

            $this->record->pin = $pin;
        }

        // Convert empty strings to null for nullable fields
        foreach (['salutation', 'country'] as $field) {
            if ($this->record->$field === '') {
                $this->record->$field = null;
            }
        }

        Log::info('DealerImport: saving', [
            'email' => $this->record->email,
            'pin' => $this->record->pin,
            'is_new' => ! $this->record->exists,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = Number::format($import->successful_rows) . ' dealers imported/updated.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' failed.';
        }

        return $body;
    }
}
