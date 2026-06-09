<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameCardSeeder extends Seeder
{
    private array $countries = [
        'France' => [
           
         
           
            'Eduardo Camavinga',
            'Aurelien Tchouameni',
            'Kingsley Coman',
            'Antoine Griezmann',
        'Ousmane Dembele',
             'Kylian Mbappe',
        ],
        'Spain' => [
          
           
            'Nico Williams',
            'Dani Olmo',
            'Rodri',
            'Gavi',
            'Pedri',
            'Lamine Yamal',
        ],
        'Argentina' => [          
            'Lautaro Martinez',
            'Alexis Mac Allister',
            'Enzo Fernandez',
            'Rodrigo De Paul',
             'Julian Alvarez',
             'Lionel Messi',
        ],
        'England' => [
           
           
            'Bukayo Saka',
            'Phil Foden',
            'Declan Rice',
            'Cole Palmer',
             'Jude Bellingham',
             'Harry Kane',
        ],
        'Brazil' => [
           
            'Rodrygo',          
            'Bruno Guimaraes',
            'Lucas Paqueta',
            'Gabriel Martinelli',
             'Vinicius Junior',
             'Neymar Jr',
        ],
        'Portugal' => [
           
          
            'Bernardo Silva',
            'Ruben Dias',
            'Rafael Leao',
            'Joao Cancelo',
              'Bruno Fernandes',
             'Cristiano Ronaldo',
        ],
        'Germany' => [
            'Jamal Musiala',
            'Florian Wirtz',
            'Kai Havertz',
            'Joshua Kimmich',
            'Antonio Rudiger',
            'Manuel Neuer',
        ],
        'Netherlands' => [
            
            'Frenkie de Jong',
            'Memphis Depay',
            'Xavi Simons',
            'Denzel Dumfries',
            'Cody Gakpo',
            'Virgil van Dijk',
        ],
        'Belgium' => [          
            'Jeremy Doku',
            'Youri Tielemans',
            'Leandro Trossard',
            'Thibaut Courtois',
              'Romelu Lukaku',
             'Kevin De Bruyne',
        ],
        'Croatia' => [
          
            'Mateo Kovacic',
            'Josko Gvardiol',
            'Marcelo Brozovic',
            'Ivan Perisic',
            'Andrej Kramaric',
              'Luka Modric',
        ],
    ];

    private array $cards = [
        ['Bronze1', 'BRONZE', 1, 2],
        ['Bronze2', 'BRONZE', 2, 2],
        ['Silver1', 'SILVER', 3, 3],
        ['Silver2', 'SILVER', 4, 3],
        ['Gold1', 'GOLD', 5, 5],
        ['Gold2', 'GOLD', 6, 5],
    ];

    public function run(): void
    {
        foreach ($this->countries as $countryName => $players) {
            $team = DB::table('teams')
                ->where('name', $countryName)
                ->first();

            if (!$team) {
                continue;
            }

            foreach ($this->cards as $index => $card) {
                $cardCode = strtoupper(substr($countryName, 0, 3)) . '-' . ($index + 1);

                DB::table('game_card')->updateOrInsert(
                    ['card_code' => $cardCode],
                    [
                        'country_id' => $team->id,
                        'card_name' => $card[0],
                        'player_name' => $players[$index],
                        'card_type' => $card[1],
                        'card_order' => $card[2],
                        'star_value' => $card[3],
                        'is_active' => true,
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
