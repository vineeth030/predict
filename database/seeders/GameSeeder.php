<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    private $games = [
        [1,2,"1718391600000","Group Stage","upcoming"],
        [3,4,"1718456400000","Group Stage","upcoming"],
        [5,6,"1718467200000","Group Stage","upcoming"],
        [7,8,"1718478000000","Group Stage","upcoming"],
        [13,14,"1718542800000","Group Stage","upcoming"],
        [9,10,"1718553600000","Group Stage","upcoming"],
        [11,12,"1718564400000","Group Stage","upcoming"],
        [19,20,"1718629200000","Group Stage","upcoming"],
        [17,18,"1718640000000","Group Stage","upcoming"],
        [15,16,"1718391600000","Group Stage","upcoming"],
        [21,22,"1718726400000","Group Stage","upcoming"],
        [23,24,"1718737200000","Group Stage","upcoming"],
        [6,8,"1718802000000","Group Stage","upcoming"],
        [1,3,"1718812800000","Group Stage","upcoming"],
        [2,4,"1718823600000","Group Stage","upcoming"],
        [9,11,"1718888400000","Group Stage","upcoming"],
        [10,12,"1718899200000","Group Stage","upcoming"],
        [5,7,"1718910000000","Group Stage","upcoming"],
        [18,20,"1718974800000","Group Stage","upcoming"],
        [13,15,"1718985600000","Group Stage","upcoming"],
        [14,16,"1718996400000","Group Stage","upcoming"],
        [22,24,"1719061200000","Group Stage","upcoming"],
        [21,23,"1719072000000","Group Stage","upcoming"],
        [17,19,"1719082800000","Group Stage","upcoming"],
        [2,3,"1719169200000","Group Stage","upcoming"],
        [4,1,"1719169200000","Group Stage","upcoming"],
        [8,5,"1719255600000","Group Stage","upcoming"],
        [6,7,"1719255600000","Group Stage","upcoming"],
        [16,13,"1719331200000","Group Stage","upcoming"],
        [14,15,"1719331200000","Group Stage","upcoming"],
        [10,11,"1719342000000","Group Stage","upcoming"],
        [12,9,"1719342000000","Group Stage","upcoming"],
        [18,19,"1719417600000","Group Stage","upcoming"],
        [20,17,"1719417600000","Group Stage","upcoming"],
        [24,21,"1719428400000","Group Stage","upcoming"],
        [22,23,"1719428400000","Group Stage","upcoming"],



    ];
    public function run(): void
    {
        foreach ($this->games as $key => $game) {

            \App\Models\Game::factory()->create([
                'team_one_id' => $game[0],
                'team_two_id' => $game[1],
                'kick_off_time' => $game[2],
                'game_type' => $game[3],
                'match_status' => $game[4],

            ]);
        }
    }
}
