<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    public function run(): void
    {
        Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Mustermann',
            'email' => 'max@mustermann.de',
            'pin' => '123456',
        ]);

        Dealer::create([
            'first_name' => 'Erika',
            'last_name' => 'Musterfrau',
            'email' => 'erika@musterfrau.de',
            'pin' => '654321',
        ]);

        Dealer::factory(5)->create();
    }
}
