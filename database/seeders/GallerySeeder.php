<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            ['title' => 'Empfang im Foyer', 'description' => 'Ankunft der Gaeste am Montagabend', 'status' => 'live'],
            ['title' => 'Keynote Eroeffnung', 'description' => 'Begruessung durch die Geschaeftsfuehrung', 'status' => 'live'],
            ['title' => 'Betriebsbesichtigung', 'description' => 'Rundgang durch die Produktion', 'status' => 'live'],
            ['title' => 'Workshop Sales Insights', 'description' => null, 'status' => 'live'],
            ['title' => 'Networking Dinner', 'description' => 'Gemeinsames Abendessen im Hotel', 'status' => 'live'],
            ['title' => 'Partnerprogramm Stadtrundfahrt', 'description' => 'Sightseeing Tour fuer Begleitpersonen', 'status' => 'live'],
            ['title' => 'Podiumsdiskussion', 'description' => 'Zukunft des Handels', 'status' => 'live'],
            ['title' => 'Gruppenfoto', 'description' => 'Alle Teilnehmer vor dem Firmengebaeude', 'status' => 'live'],
            ['title' => 'Abschlussabend (unbearbeitet)', 'description' => 'Noch in Bearbeitung', 'status' => 'draft'],
        ];

        // Erstelle Platzhalter-Bilder (1x1 PNG)
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
                'status' => $data['status'],
                'sort_order' => $i + 1,
            ]);
        }
    }
}
