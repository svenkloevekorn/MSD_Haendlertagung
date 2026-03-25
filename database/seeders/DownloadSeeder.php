<?php

namespace Database\Seeders;

use App\Models\Download;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy-Dateien im private Storage erstellen
        $files = [
            [
                'name' => 'Sales Insights 2026',
                'description' => 'Aktuelle Verkaufszahlen und Marktanalyse',
                'filename' => 'sales-insights-2026.pdf',
                'content' => 'Dummy PDF content',
                'status' => 'live',
                'sort_order' => 1,
            ],
            [
                'name' => 'Produktkatalog Herbst/Winter',
                'description' => 'Alle neuen Produkte fuer die kommende Saison',
                'filename' => 'produktkatalog-hw-2026.pdf',
                'content' => 'Dummy PDF content',
                'status' => 'live',
                'sort_order' => 2,
            ],
            [
                'name' => 'Preisliste 2026/2027',
                'description' => null,
                'filename' => 'preisliste-2026-2027.xlsx',
                'content' => 'Dummy Excel content',
                'status' => 'live',
                'sort_order' => 3,
            ],
            [
                'name' => 'Keynote – Zukunft des Handels',
                'description' => 'Vortrag von Prof. Dr. Schmidt',
                'filename' => 'keynote-zukunft-handel.pptx',
                'content' => 'Dummy PPT content',
                'status' => 'live',
                'sort_order' => 4,
            ],
            [
                'name' => 'Fotos Betriebsbesichtigung',
                'description' => 'Impressionen vom Werksrundgang',
                'filename' => 'fotos-betriebsbesichtigung.zip',
                'content' => 'Dummy ZIP content',
                'status' => 'live',
                'sort_order' => 5,
            ],
            [
                'name' => 'Competitive Analysis (Entwurf)',
                'description' => 'Noch in Bearbeitung',
                'filename' => 'competitive-analysis-draft.pdf',
                'content' => 'Dummy PDF content',
                'status' => 'draft',
                'sort_order' => 6,
            ],
        ];

        foreach ($files as $file) {
            $path = 'downloads/' . $file['filename'];
            Storage::disk('local')->put($path, $file['content']);

            Download::create([
                'name' => $file['name'],
                'description' => $file['description'],
                'file_path' => $path,
                'original_filename' => $file['filename'],
                'file_size' => Storage::disk('local')->size($path),
                'status' => $file['status'],
                'sort_order' => $file['sort_order'],
            ]);
        }
    }
}
