<?php

namespace App\Filament\Resources\FormSubmissions\Tables;

use App\Models\FormSubmission;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FormSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form_slug')
                    ->label('Form')
                    ->formatStateUsing(fn (string $state): string => FormSubmission::$formLabels[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'registration' => 'success',
                        'feedback' => 'info',
                        'contact' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('data.first_name')
                    ->label('First Name')
                    ->getStateUsing(fn ($record) => $record->data['first_name'] ?? $record->data['name'] ?? '-'),
                TextColumn::make('data.last_name')
                    ->label('Last Name')
                    ->getStateUsing(fn ($record) => $record->data['last_name'] ?? '-'),
                TextColumn::make('data.email')
                    ->label('Email')
                    ->getStateUsing(fn ($record) => $record->data['email'] ?? '-'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('form_slug')
                    ->label('Form')
                    ->options(FormSubmission::$formLabels),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
