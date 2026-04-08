<?php

namespace App\Filament\Resources\Dealers\Tables;

use App\Models\Dealer;
use App\Models\FormSubmission;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
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
                TextColumn::make('todo_status')
                    ->label('Status')
                    ->getStateUsing(fn (Dealer $record) => self::getTodoCount($record))
                    ->formatStateUsing(fn ($state) => $state === 0
                        ? new HtmlString('<span class="text-green-600 font-medium">&#10003; All done</span>')
                        : new HtmlString('<span class="text-amber-600 font-medium">' . $state . ' open</span>'))
                    ->sortable(query: fn ($query, string $direction) => $query
                        ->orderByRaw('(SELECT COUNT(*) FROM form_submissions WHERE form_submissions.dealer_id = dealers.id) ' . ($direction === 'asc' ? 'DESC' : 'ASC'))),
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

    private static function getTodoCount(Dealer $dealer): int
    {
        $regData = FormSubmission::where('form_slug', FormSubmission::FORM_REGISTRATION)
            ->where('dealer_id', $dealer->id)->first()?->data ?? [];
        $marketData = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)
            ->where('dealer_id', $dealer->id)->first()?->data ?? [];
        $hasFeedback = FormSubmission::where('form_slug', FormSubmission::FORM_FEEDBACK)
            ->where('dealer_id', $dealer->id)->exists();

        $count = 0;

        // Market Info (all 5 fields)
        $hasMarketInfo = !empty($marketData['market_share'] ?? null)
            && !empty($marketData['challenges'] ?? null)
            && !empty($marketData['chances_potential'] ?? null)
            && !empty($marketData['competitors'] ?? null)
            && !empty($marketData['expectations'] ?? null);
        if (!$hasMarketInfo) $count++;

        // Factory Tour
        if (empty($regData['factory_tour'] ?? null)) $count++;

        // Activities
        if (empty($regData['activity_1'] ?? null) || empty($regData['activity_2'] ?? null) || empty($regData['activity_3'] ?? null)) $count++;

        // Allergies
        if (empty($regData['allergies'] ?? null) && ($regData['no_allergies'] ?? '') !== 'true') $count++;

        // Mobile Numbers
        $hasCompanion = ($regData['no_companion'] ?? '') === 'true' || !empty($regData['companion_mobile'] ?? null);
        if (empty($regData['mobile'] ?? null) || !$hasCompanion) $count++;

        // Feedback
        if (!$hasFeedback) $count++;

        return $count;
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
