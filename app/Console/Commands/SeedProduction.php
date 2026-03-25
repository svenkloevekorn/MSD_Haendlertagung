<?php

namespace App\Console\Commands;

use App\Models\Dealer;
use App\Models\Download;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:seed-production')]
#[Description('Seed production database with demo data (no Faker needed)')]
class SeedProduction extends Command
{
    public function handle()
    {
        // Admin User
        if (! User::where('email', 'admin@admin.de')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.de',
                'password' => bcrypt('password'),
            ]);
            $this->info('Admin-User angelegt (admin@admin.de / password)');
        } else {
            $this->warn('Admin-User existiert bereits');
        }

        // Test-Haendler
        $dealers = [
            ['first_name' => 'Max', 'last_name' => 'Mustermann', 'email' => 'max@mustermann.de', 'pin' => '123456'],
            ['first_name' => 'Erika', 'last_name' => 'Musterfrau', 'email' => 'erika@musterfrau.de', 'pin' => '654321'],
        ];

        foreach ($dealers as $data) {
            if (! Dealer::where('email', $data['email'])->exists()) {
                Dealer::create($data);
                $this->info("Haendler {$data['first_name']} {$data['last_name']} angelegt (PIN: {$data['pin']})");
            } else {
                $this->warn("Haendler {$data['email']} existiert bereits");
            }
        }

        // Downloads
        if (Download::count() === 0) {
            $downloads = [
                ['name' => 'Sales Insights 2026', 'description' => 'Aktuelle Verkaufszahlen und Marktanalyse', 'filename' => 'sales-insights-2026.pdf', 'status' => 'live', 'sort_order' => 1],
                ['name' => 'Produktkatalog Herbst/Winter', 'description' => 'Alle neuen Produkte', 'filename' => 'produktkatalog-hw-2026.pdf', 'status' => 'live', 'sort_order' => 2],
                ['name' => 'Preisliste 2026/2027', 'description' => null, 'filename' => 'preisliste-2026-2027.xlsx', 'status' => 'live', 'sort_order' => 3],
                ['name' => 'Keynote – Zukunft des Handels', 'description' => 'Vortrag von Prof. Dr. Schmidt', 'filename' => 'keynote-zukunft-handel.pptx', 'status' => 'live', 'sort_order' => 4],
                ['name' => 'Fotos Betriebsbesichtigung', 'description' => 'Impressionen vom Werksrundgang', 'filename' => 'fotos-betriebsbesichtigung.zip', 'status' => 'live', 'sort_order' => 5],
            ];

            foreach ($downloads as $dl) {
                $path = 'downloads/' . $dl['filename'];
                Storage::disk('local')->put($path, 'Dummy content');
                Download::create([
                    'name' => $dl['name'],
                    'description' => $dl['description'],
                    'file_path' => $path,
                    'original_filename' => $dl['filename'],
                    'file_size' => Storage::disk('local')->size($path),
                    'status' => $dl['status'],
                    'sort_order' => $dl['sort_order'],
                ]);
            }
            $this->info(count($downloads) . ' Downloads angelegt');
        } else {
            $this->warn('Downloads existieren bereits');
        }

        // Galerie
        if (GalleryImage::count() === 0) {
            $images = [
                ['title' => 'Empfang im Foyer', 'description' => 'Ankunft der Gaeste am Montagabend'],
                ['title' => 'Keynote Eroeffnung', 'description' => 'Begruessung durch die Geschaeftsfuehrung'],
                ['title' => 'Betriebsbesichtigung', 'description' => 'Rundgang durch die Produktion'],
                ['title' => 'Workshop Sales Insights', 'description' => null],
                ['title' => 'Networking Dinner', 'description' => 'Gemeinsames Abendessen im Hotel'],
                ['title' => 'Gruppenfoto', 'description' => 'Alle Teilnehmer vor dem Firmengebaeude'],
            ];

            $placeholder = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==');

            foreach ($images as $i => $data) {
                $filename = 'bild-' . ($i + 1) . '.png';
                $path = 'gallery/' . $filename;
                Storage::disk('local')->put($path, $placeholder);
                GalleryImage::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'image_path' => $path,
                    'original_filename' => $filename,
                    'file_size' => Storage::disk('local')->size($path),
                    'status' => 'live',
                    'sort_order' => $i + 1,
                ]);
            }
            $this->info(count($images) . ' Galerie-Bilder angelegt');
        } else {
            $this->warn('Galerie-Bilder existieren bereits');
        }

        $this->newLine();
        $this->info('Fertig!');
    }
}
