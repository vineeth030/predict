<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,12),
            'game_id' => rand(1,20),
            'points' => rand(0,5),
            'win_prediction' => rand(2,6),
            'goal_prediction' => rand(2,6),
            'first_goal_prediction' => rand(2,6),
        ];
    }
}
