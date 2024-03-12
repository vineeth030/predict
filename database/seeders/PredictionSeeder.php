<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Database\Factories\PredictionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::select('id')->get();

        foreach ($users as $key => $user_id) {
            
            $games = Game::select('id', 'team_one_id', 'team_two_id')->get();

            foreach ($games as $key => $game) {
                
                \App\Models\Prediction::factory()->create([
                    'user_id' => $user_id,
                    'game_id' => $game->id,
                    'team_one_goals' => rand(0, 2),
                    'team_two_goals' => rand(0, 2),
                    'winning_team_id' => rand(0, 2) == 0 ? $game->team_one_id : $game->team_two_id
                ]);
            }
        }

        
    }
}
