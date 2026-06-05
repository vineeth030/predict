<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
   private $games = [
        // --- 12 Jun ---
        [1, 2, "1781224200000", "Group Stage", "upcoming", "Mexico City Stadium"],       // Mexico vs South Africa | 12:30 am
        [3, 4, "1781249400000", "Group Stage", "upcoming", "Estadio Guadalajara"],      // South Korea vs Czechia | 7:30 am

        // --- 13 Jun ---
        [5, 6, "1781310600000", "Group Stage", "upcoming", "Toronto Stadium"],           // Canada vs Bosnia and Herzegovina | 12:30 am
        [13, 14, "1781332200000", "Group Stage", "upcoming", "Los Angeles Stadium"],     // USA vs Paraguay | 6:30 am

        // --- 14 Jun ---
        [7, 8, "1781397000000", "Group Stage", "upcoming", "Boston Stadium"],            // Qatar vs Switzerland | 12:30 am
        [9, 10, "1781407800000", "Group Stage", "upcoming", "BC Place Vancouver"],       // Brazil vs Morocco | 3:30 am
        [11, 12, "1781418600000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // Haiti vs Scotland | 6:30 am
        [15, 16, "1781429400000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // Australia vs Turkey | 9:30 am
        [17, 18, "1781476200000", "Group Stage", "upcoming", "Philadelphia Stadium"],    // Germany vs Curacao | 10:30 pm

        // --- 15 Jun ---
        [21, 22, "1781487000000", "Group Stage", "upcoming", "Houston Stadium"],         // Netherlands vs Japan | 1:30 am
        [19, 20, "1781497800000", "Group Stage", "upcoming", "Dallas Stadium"],          // Ivory Coast vs Ecuador | 4:30 am
        [23, 24, "1781508600000", "Group Stage", "upcoming", "Estadio Monterrey"],      // Sweden vs Tunisia | 7:30 am
        [29, 30, "1781559000000", "Group Stage", "upcoming", "Miami Stadium"],           // Spain vs Cape Verde | 9:30 pm

        // --- 16 Jun ---
        [25, 26, "1781569800000", "Group Stage", "upcoming", "Atlanta Stadium"],         // Belgium vs Egypt | 12:30 am
        [31, 32, "1781580600000", "Group Stage", "upcoming", "Los Angeles Stadium"],     // Saudi Arabia vs Uruguay | 3:30 am
        [27, 28, "1781591400000", "Group Stage", "upcoming", "Seattle Stadium"],           // Iran vs New Zealand | 6:30 am

        // --- 17 Jun ---
        [33, 34, "1781656200000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // France vs Senegal | 12:30 am
        [35, 36, "1781667000000", "Group Stage", "upcoming", "Boston Stadium"],          // Iraq vs Norway | 3:30 am
        [37, 38, "1781677800000", "Group Stage", "upcoming", "Miami Stadium"],           // Argentina vs Algeria | 6:30 am
        [39, 40, "1781688600000", "Group Stage", "upcoming", "Atlanta Stadium"],           // Austria vs Jordan | 9:30 am
        [41, 42, "1781735400000", "Group Stage", "upcoming", "Kansas City Stadium"],

        

        // --- 18 Jun ---
        [45, 46, "1781746200000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // England vs Croatia | 1:30 am
        [47, 48, "1781757000000", "Group Stage", "upcoming", "Toronto Stadium"],         // Ghana vs Panama | 4:30 am
        [43, 44, "1781767800000", "Group Stage", "upcoming", "Dallas Stadium"],          // Uzbekistan vs Colombia | 7:30 am
        [4, 2, "1781818200000", "Group Stage", "upcoming", "Houston Stadium"],           // Czechia vs South Africa | 9:30 pm

        // --- 19 Jun ---
        [8, 6, "1781829000000", "Group Stage", "upcoming", "Mexico City Stadium"],       // Switzerland vs Bosnia and Herzegovina | 12:30 am
        [5, 7, "1781839800000", "Group Stage", "upcoming", "Atlanta Stadium"],           // Canada vs Qatar | 3:30 am
        [1, 3, "1781850600000", "Group Stage", "upcoming", "Los Angeles Stadium"],       // Mexico vs South Korea | 6:30 am

        // --- 20 Jun ---
        [13, 15, "1781915400000", "Group Stage", "upcoming", "BC Place Vancouver"],       // USA vs Australia | 12:30 am
        [12, 10, "1781926200000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // Scotland vs Morocco | 3:30 am
        [9, 11, "1781935200000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // Brazil vs Haiti | 6:00 am
        [16, 14, "1781944200000", "Group Stage", "upcoming", "Seattle Stadium"],         // Turkey vs Paraguay | 8:30 am
        [21, 23, "1781994600000", "Group Stage", "upcoming", "Toronto Stadium"],         // Netherlands vs Sweden | 10:30 pm

        // --- 21 Jun ---
        [17, 19, "1782005400000", "Group Stage", "upcoming", "Kansas City Stadium"],     // Germany vs Ivory Coast | 1:30 am
        [20, 18, "1782019800000", "Group Stage", "upcoming", "Houston Stadium"],          // Ecuador vs Curacao | 5:30 am
        [24, 22, "1782034200000", "Group Stage", "upcoming", "Estadio Monterrey"],       // Tunisia vs Japan | 9:30 am
        [29, 31, "1782077400000", "Group Stage", "upcoming", "Miami Stadium"],           // Spain vs Saudi Arabia | 9:30 pm

        // --- 22 Jun ---
        [25, 27, "1782088200000", "Group Stage", "upcoming", "Atlanta Stadium"],         // Belgium vs Iran | 12:30 am
        [32, 30, "1782099000000", "Group Stage", "upcoming", "Los Angeles Stadium"],     // Uruguay vs Cape Verde | 3:30 am
        [28, 26, "1782109800000", "Group Stage", "upcoming", "BC Place Vancouver"],       // New Zealand vs Egypt | 6:30 am
        [37, 39, "1782167400000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // Argentina vs Austria | 10:30 pm

        // --- 23 Jun ---
        [33, 35, "1782181800000", "Group Stage", "upcoming", "Philadelphia Stadium"],    // France vs Iraq | 2:30 am
        [36, 34, "1782192600000", "Group Stage", "upcoming", "Dallas Stadium"],          // Norway vs Senegal | 5:30 am
        [40, 38, "1782203400000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // Jordan vs Algeria | 8:30 am
        [41, 43, "1782253800000", "Group Stage", "upcoming", "Boston Stadium"],          // Portugal vs Uzbekistan | 10:30 pm

        // --- 24 Jun ---
        [45, 47, "1782264600000", "Group Stage", "upcoming", "Toronto Stadium"],         // England vs Ghana | 1:30 am
        [48, 46, "1782275400000", "Group Stage", "upcoming", "Houston Stadium"],          // Panama vs Croatia | 4:30 am
        [44, 42, "1782286200000", "Group Stage", "upcoming", "Estadio Guadalajara"],      // Colombia vs DR Congo | 7:30 am

        // --- 25 Jun --- (Simultaneous Group Finales Begin)
        [8, 5, "1782347400000", "Group Stage", "upcoming", "Miami Stadium"],             // Switzerland vs Canada | 12:30 am
        [6, 7, "1782347400000", "Group Stage", "upcoming", "Atlanta Stadium"],           // Bosnia and Herzegovina vs Qatar | 12:30 am
        [10, 11, "1782358200000", "Group Stage", "upcoming", "BC Place Vancouver"],       // Morocco vs Haiti | 3:30 am
        [12, 9, "1782358200000", "Group Stage", "upcoming", "Seattle Stadium"],           // Scotland vs Brazil | 3:30 am
        [2, 3, "1782369000000", "Group Stage", "upcoming", "Mexico City Stadium"],       // South Africa vs South Korea | 6:30 am
        [4, 1, "1782369000000", "Group Stage", "upcoming", "Estadio Monterrey"],       // Czechia vs Mexico | 6:30 am

        // --- 26 Jun ---
        [18, 19, "1782437400000", "Group Stage", "upcoming", "Dallas Stadium"],          // Curacao vs Ivory Coast | 1:30 am
        [20, 17, "1782437400000", "Group Stage", "upcoming", "Kansas City Stadium"],     // Ecuador vs Germany | 1:30 am
        [24, 21, "1782448200000", "Group Stage", "upcoming", "Los Angeles Stadium"],     // Tunisia vs Netherlands | 4:30 am
        [22, 23, "1782448200000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // Japan vs Sweden | 4:30 am
        [16, 13, "1782459000000", "Group Stage", "upcoming", "Philadelphia Stadium"],    // Turkey vs USA | 7:30 am
        [14, 15, "1782459000000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // Paraguay vs Australia | 7:30 am

        // --- 27 Jun ---
        [36, 33, "1782520200000", "Group Stage", "upcoming", "Boston Stadium"],          // Norway vs France | 12:30 am
        [34, 35, "1782520200000", "Group Stage", "upcoming", "Houston Stadium"],          // Senegal vs Iraq | 12:30 am
        [30, 31, "1782538200000", "Group Stage", "upcoming", "Miami Stadium"],           // Cape Verde vs Saudi Arabia | 5:30 am
        [32, 29, "1782538200000", "Group Stage", "upcoming", "Atlanta Stadium"],           // Uruguay vs Spain | 5:30 am
        [28, 25, "1782549000000", "Group Stage", "upcoming", "Philadelphia Stadium"],    // New Zealand vs Belgium | 8:30 am
        [26, 27, "1782549000000", "Group Stage", "upcoming", "New York New Jersey Stadium"], // Egypt vs Iran | 8:30 am

        // --- 28 Jun ---      
        [48, 45, "1782613800000", "Group Stage", "upcoming", "Kansas City Stadium"],     // Panama vs England | 2:30 am (Closing Match)
        [46, 47, "1782613800000", "Group Stage", "upcoming", "Louisville Stadium"],      // Croatia vs Ghana | 2:30 am
        [44, 41, "1782622800000", "Group Stage", "upcoming", "Denver Stadium"],          // Colombia vs Portugal | 5:00 am
        [42, 43, "1782622800000", "Group Stage", "upcoming", "San Francisco Bay Area Stadium"], // DR Congo vs Uzbekistan | 5:00 am
        [38, 39, "1782631800000", "Group Stage", "upcoming", "Seattle Stadium"],         // Algeria vs Austria | 7:30 am
        [40, 37, "1782631800000", "Group Stage", "upcoming", "Dallas Stadium"],          // Jordan vs Argentina | 7:30 am
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