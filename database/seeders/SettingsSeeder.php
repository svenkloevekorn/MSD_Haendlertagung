<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'mail_from_name' => 'Mühlen Sohn',
            'mail_from_address' => 'info@muehlen-sohn.de',
            'confirmation_registration' => 'Thank you for your registration! We look forward to seeing you at the International Sales Meeting 2026.',
            'confirmation_feedback' => 'Thank you for your feedback! Your input helps us improve future events.',
            'confirmation_contact' => 'Thank you for your message! We will get back to you shortly.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
