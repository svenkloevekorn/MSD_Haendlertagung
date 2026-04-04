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
                        'market_info' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('dealer.first_name')
                    ->label('Dealer')
                    ->getStateUsing(fn ($record) => $record->dealer
                        ? $record->dealer->first_name . ' ' . $record->dealer->last_name
                        : '-')
                    ->searchable(query: fn ($query, string $search) => $query->whereHas('dealer', fn ($q) => $q
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                    )),
                TextColumn::make('dealer.pin')
                    ->label('PIN')
                    ->getStateUsing(fn ($record) => $record->dealer?->pin ?? '-'),
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
