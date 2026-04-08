<?php

namespace App\Filament\Resources\Downloads\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DownloadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('original_filename')
                    ->label('Datei')
                    ->searchable(),
                TextColumn::make('file_size')
                    ->label('Groesse')
                    ->formatStateUsing(function ($state) {
                        if ($state >= 1048576) {
                            return round($state / 1048576, 1) . ' MB';
                        }
                        return round($state / 1024) . ' KB';
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'live' => 'success',
                        'draft' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'live' => 'Live',
                        'draft' => 'Entwurf',
                    }),
                TextColumn::make('download_count')
                    ->label('Downloads')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Reihenfolge')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Erstellt')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('setLive')
                        ->label('Set Live')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each(fn ($r) => $r->update(['status' => 'live'])))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('setDraft')
                        ->label('Set Draft')
                        ->icon('heroicon-o-x-circle')
                        ->color('gray')
                        ->action(fn (Collection $records) => $records->each(fn ($r) => $r->update(['status' => 'draft'])))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
