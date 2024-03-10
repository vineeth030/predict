<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'short_name' => fake()->word(),
            'group_id' => rand(1,6),
            'points' => rand(0,10),
            'games_played' => rand(1,3),
            'wins' => rand(1,3),
            'draws' => rand(1,2),
            'losses' => rand(1,2)
        ];
    }
}
