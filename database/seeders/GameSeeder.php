<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
   private $games = [
        // --- 12 Jun ---
        [2, 5, "1782673200000", "Round of 32", "upcoming", "Los Angeles Stadium"],       // Mexico vs South Africa | 12:30 am
        [21, 10, "1782781200000", "Round of 32", "upcoming", "Monterrey Stadium"],      // South Korea vs Czechia | 7:30 am


    ];

    public function run(): void
    {
        $now = now();

        $data = array_map(function ($game) use ($now) {
            return [
                'team_one_id'   => $game[0],
                'team_two_id'   => $game[1],
                'kick_off_time' => $game[2],
                'game_type'     => $game[3],
                'match_status'  => $game[4],
                'stadium_name'  => $game[5],
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }, $this->games);

        Game::insert($data);
    }
}