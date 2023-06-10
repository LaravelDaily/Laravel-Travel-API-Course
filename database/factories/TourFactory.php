<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'starting_date' => now(),
            'ending_date' => now()->addDays(rand(1, 10)),
            'price' => fake()->randomFloat(2, 10, 999),
        ];
    }
}
