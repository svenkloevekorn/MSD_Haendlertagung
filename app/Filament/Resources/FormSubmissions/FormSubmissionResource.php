<?php

namespace App\Filament\Resources\FormSubmissions;

use App\Filament\Resources\FormSubmissions\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissions\Pages\ViewFormSubmission;
use App\Filament\Resources\FormSubmissions\Tables\FormSubmissionsTable;
use App\Models\FormSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Submissions';

    protected static ?string $modelLabel = 'Submission';

    protected static ?string $pluralModelLabel = 'Submissions';

    public static function table(Table $table): Table
    {
        return FormSubmissionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormSubmissions::route('/'),
            'view' => ViewFormSubmission::route('/{record}'),
        ];
    }
}
