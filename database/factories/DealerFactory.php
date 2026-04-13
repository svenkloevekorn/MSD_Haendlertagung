<?php

namespace Database\Factories;

use App\Models\Dealer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dealer>
 */
class DealerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'pin' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'is_internal' => false,
            'last_login_at' => null,
        ];
    }
}
