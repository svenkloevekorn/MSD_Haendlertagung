<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $speakers = [
            ['name' => 'Speaker 1', 'subtitle' => 'Guest Speaker – Paper', 'status' => 'live', 'sort_order' => 1],
            ['name' => 'Speaker 2', 'subtitle' => 'Guest Speaker – Glue', 'status' => 'live', 'sort_order' => 2],
            ['name' => 'Speaker 3', 'subtitle' => 'Guest Speaker', 'status' => 'live', 'sort_order' => 3],
            ['name' => 'Speaker 4', 'subtitle' => 'Guest Speaker', 'status' => 'live', 'sort_order' => 4],
        ];

        foreach ($speakers as $data) {
            Speaker::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
