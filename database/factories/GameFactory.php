<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $team_one_id = rand(1,11);
        $team_two_id = rand(12,23);

        return [
            'team_one_id' => $team_one_id,
            'team_two_id' => $team_two_id,
            'team_one_goals' => null,
            'team_two_goals' => null,
            'match_status' => 'upcoming',
            'winning_team_id' => null,
            'kick_off_time' => Carbon::now(),
            'game_type' => 'Group Stage',
            'first_goal_team_id' => null
        ];
    }
}
