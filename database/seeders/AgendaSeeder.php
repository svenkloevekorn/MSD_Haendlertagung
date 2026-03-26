<?php

namespace Database\Seeders;

use App\Models\AgendaDay;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        // Montag
        $montag = AgendaDay::updateOrCreate(
            ['date' => '2026-06-29'],
            ['tab_label' => 'Mo, 29.06.', 'title' => 'Montag – Anreisetag', 'subtitle' => '29. Juni 2026', 'sort_order' => 1]
        );
        $montag->items()->delete();
        $montag->items()->createMany([
            ['overline' => 'Nachmittag', 'title' => 'Check-in im Hotel', 'description' => 'Ankunft und Zimmerbezug im Hotel Lago', 'sort_order' => 1],
            ['overline' => '19:00 Uhr', 'title' => 'Gemeinsames Abendessen', 'description' => 'Restaurant wird noch bekannt gegeben', 'sort_order' => 2],
        ]);

        // Dienstag
        $dienstag = AgendaDay::updateOrCreate(
            ['date' => '2026-06-30'],
            ['tab_label' => 'Di, 30.06.', 'title' => 'Dienstag – Tag 1', 'subtitle' => '30. Juni 2026 · Meeting Day', 'sort_order' => 2]
        );
        $dienstag->items()->delete();
        $dienstag->items()->createMany([
            ['overline' => 'ab 08:00 Uhr', 'title' => 'Check-in & Empfang', 'sort_order' => 1],
            ['overline' => '09:00 Uhr', 'title' => 'Eröffnung & Begrüßung', 'description' => 'The Next Generation', 'sort_order' => 2],
            ['overline' => 'Vormittag', 'title' => 'Sales Insights', 'sort_order' => 3],
            ['overline' => 'Vormittag', 'title' => 'SMP Insights', 'sort_order' => 4],
            ['overline' => '12:00 Uhr', 'title' => 'Lunch', 'sort_order' => 5],
            ['overline' => '13:00 Uhr', 'title' => 'Highlights and Challenges in Sales', 'description' => 'Invite from our Sales Partners', 'sort_order' => 6],
            ['overline' => 'Nachmittag', 'title' => 'Quality Report', 'sort_order' => 7],
            ['overline' => 'Nachmittag', 'title' => 'Controlling with Power BI', 'sort_order' => 8],
            ['overline' => '19:00 Uhr', 'title' => 'Abendessen', 'description' => 'Restaurant Bella Vista', 'sort_order' => 9],
        ]);

        // Mittwoch
        $mittwoch = AgendaDay::updateOrCreate(
            ['date' => '2026-07-01'],
            ['tab_label' => 'Mi, 01.07.', 'title' => 'Mittwoch – Tag 2', 'subtitle' => '01. Juli 2026 · Meeting Day', 'sort_order' => 3]
        );
        $mittwoch->items()->delete();
        $mittwoch->items()->createMany([
            ['overline' => '09:00 Uhr', 'title' => 'Competitive Analysis', 'sort_order' => 1],
            ['overline' => 'Vormittag', 'title' => 'Trends and Developments – Paper', 'description' => 'Guest Speaker', 'sort_order' => 2],
            ['overline' => 'Vormittag', 'title' => 'Trends and Developments – Glue', 'description' => 'Guest Speaker', 'sort_order' => 3],
            ['overline' => '12:00 Uhr', 'title' => 'Lunch', 'sort_order' => 4],
            ['overline' => '13:00 Uhr', 'title' => 'Service Report', 'sort_order' => 5],
            ['overline' => 'Nachmittag', 'title' => 'SMP / SRAP LAG', 'sort_order' => 6],
            ['overline' => 'Nachmittag', 'title' => 'Lacing with improved hooks', 'sort_order' => 7],
            ['overline' => 'Nachmittag', 'title' => 'Belt cleaning insights', 'sort_order' => 8],
            ['overline' => 'Nachmittag', 'title' => 'Outlook: New Bottom Belt and digital printing', 'sort_order' => 9],
            ['overline' => '19:00 Uhr', 'title' => 'Abendessen', 'description' => 'Hotel Lago', 'sort_order' => 10],
        ]);

        // Donnerstag
        $donnerstag = AgendaDay::updateOrCreate(
            ['date' => '2026-07-02'],
            ['tab_label' => 'Do, 02.07.', 'title' => 'Donnerstag – Abreisetag', 'subtitle' => '02. Juli 2026 · Optional Day', 'sort_order' => 4]
        );
        $donnerstag->items()->delete();
        $donnerstag->items()->createMany([
            ['overline' => 'ab 08:00 Uhr', 'title' => 'Check-out', 'sort_order' => 1],
            ['overline' => '10:00 Uhr', 'title' => 'Optionale Betriebsbesichtigung', 'description' => 'Mühlen Sohn – Bustransfer hin und zurück', 'sort_order' => 2],
            ['overline' => '12:00 Uhr', 'title' => 'Lunch bei Mühlen Sohn', 'sort_order' => 3],
        ]);
    }
}
