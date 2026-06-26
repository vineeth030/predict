<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
   private $games = [
       
        [2, 5, "1782673200000", "Round of 32", "upcoming", "Los Angeles Stadium"],      
        [9, 22, "1782752400000", "Round of 32", "upcoming", "Houston Stadium"],      
       


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