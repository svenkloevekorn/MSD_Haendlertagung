<?php

namespace App\Filament\Pages;

use App\Models\FormSubmission;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Site Settings';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'mail_from_name' => Setting::get('mail_from_name', 'Mühlen Sohn'),
            'mail_from_address' => Setting::get('mail_from_address', 'info@muehlen-sohn.de'),
            'confirmation_registration' => Setting::get('confirmation_registration', 'Thank you for your registration! We look forward to seeing you.'),
            'confirmation_feedback' => Setting::get('confirmation_feedback', 'Thank you for your feedback! Your input helps us improve.'),
            'confirmation_contact' => Setting::get('confirmation_contact', 'Thank you for your message! We will get back to you shortly.'),
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
                Section::make('Confirmation Messages')
                    ->description('Shown to users after they submit a form.')
                    ->schema([
                        Textarea::make('confirmation_registration')
                            ->label('Registration')
                            ->rows(2),
                        Textarea::make('confirmation_feedback')
                            ->label('Feedback')
                            ->rows(2),
                        Textarea::make('confirmation_contact')
                            ->label('Contact')
                            ->rows(2),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
