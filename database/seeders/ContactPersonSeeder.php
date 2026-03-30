<?php

namespace Database\Seeders;

use App\Models\ContactPerson;
use Illuminate\Database\Seeder;

class ContactPersonSeeder extends Seeder
{
    public function run(): void
    {
        $persons = [
            ['name' => 'Contact Person 1', 'position' => 'Position / Department', 'email' => 'info@muehlen-sohn.de', 'phone' => '+49 (0) 000 000', 'status' => 'live', 'sort_order' => 1],
            ['name' => 'Contact Person 2', 'position' => 'Position / Department', 'email' => 'info@muehlen-sohn.de', 'phone' => '+49 (0) 000 000', 'status' => 'live', 'sort_order' => 2],
            ['name' => 'Contact Person 3', 'position' => 'Position / Department', 'email' => 'info@muehlen-sohn.de', 'phone' => '+49 (0) 000 000', 'status' => 'live', 'sort_order' => 3],
        ];

        foreach ($persons as $data) {
            ContactPerson::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
