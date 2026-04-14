<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'mail_from_name' => Setting::get('mail_from_name', 'Mühlen Sohn'),
            'mail_from_address' => Setting::get('mail_from_address', 'info@muehlen-sohn.de'),
            'confirmation_registration' => Setting::get('confirmation_registration', 'Thank you for your registration! We look forward to seeing you.'),
            'confirmation_feedback' => Setting::get('confirmation_feedback', 'Thank you for your feedback! Your input helps us improve.'),
            'market_info_enabled' => Setting::get('market_info_enabled', '1') === '1',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Email Sender')
                    ->description('Configure the sender for all outgoing emails.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('mail_from_name')
                            ->label('Sender Name')
                            ->required(),
                        TextInput::make('mail_from_address')
                            ->label('Sender Email')
                            ->email()
                            ->required(),
                    ]),
                Section::make('Market Info Form')
                    ->description('Control whether dealers can access the Market Info form.')
                    ->schema([
                        Toggle::make('market_info_enabled')
                            ->label('Market Info form active')
                            ->helperText('When disabled, users see a "coming soon" notice instead of the form.'),
                    ]),
                Section::make('Confirmation Messages')
                    ->description('Shown to users after they submit a form.')
                    ->schema([
                        Textarea::make('confirmation_registration')
                            ->label('Registration')
                            ->rows(2),
                        Textarea::make('confirmation_feedback')
                            ->label('Feedback')
                            ->rows(2),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
