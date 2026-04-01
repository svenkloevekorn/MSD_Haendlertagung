<?php

namespace App\Filament\Resources\Dealers\Tables;

use App\Models\Dealer;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Js;

class DealersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Vorname')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nachname')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable(),
                TextColumn::make('pin')
                    ->label('PIN')
                    ->searchable(),
                TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_login_at')
                    ->label('Letzter Login')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->placeholder('Noch nie'),
                TextColumn::make('created_at')
                    ->label('Erstellt')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                Action::make('copyCredentials')
                    ->label('')
                    ->icon(Heroicon::OutlinedClipboardDocument)
                    ->color('gray')
                    ->tooltip('Copy to clipboard')
                    ->alpineClickHandler(fn (Dealer $record): string =>
                        'window.navigator.clipboard.writeText(' . Js::from(self::buildClipboardText($record)) . ')'
                    ),
                Action::make('sendCredentials')
                    ->label('')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->color('gray')
                    ->tooltip('Send PIN via email')
                    ->url(fn (Dealer $record): string => self::buildMailtoUrl($record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function buildClipboardText(Dealer $dealer): string
    {
        $salutation = $dealer->salutation ? $dealer->salutation . ' ' : '';

        return $salutation . $dealer->first_name . ' ' . $dealer->last_name . "\n"
            . $dealer->email . "\n"
            . 'PIN: ' . $dealer->pin . "\n"
            . ($dealer->country ? 'Country: ' . $dealer->country : '');
    }

    private static function buildMailtoUrl(Dealer $dealer): string
    {
        $salutation = $dealer->salutation ? $dealer->salutation . ' ' : '';
        $name = $salutation . $dealer->first_name . ' ' . $dealer->last_name;
        $siteUrl = config('app.url', 'https://haendlertagung-staging.beqn.io');

        $subject = 'Your access to the International Sales Meeting 2026';

        $body = "Dear {$name},\n\n"
            . "We are pleased to invite you to the Mühlen Sohn International Sales Meeting 2026.\n\n"
            . "Here are your personal access credentials:\n\n"
            . "Website: {$siteUrl}\n"
            . "Your PIN: {$dealer->pin}\n\n"
            . "We look forward to seeing you!\n\n"
            . "Best regards,\n"
            . "Mühlen Sohn";

        return 'mailto:' . $dealer->email
            . '?subject=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);
    }
}
