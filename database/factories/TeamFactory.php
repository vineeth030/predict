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
            'group_id' => 0,
            'points' => 0,
            'games_played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'GF' => 0,
            'GA' => 0,
            'GD' => 0
        ];
    }
}
