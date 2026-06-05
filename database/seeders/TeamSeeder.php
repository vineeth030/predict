<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
private $teams = [

    ["Mexico", "MX", "Group A", "Mexico.png"],
    ["South Africa", "SA", "Group A", "SouthAfrica.png"],
    ["South Korea", "KR", "Group A", "SouthKorea.png"],
    ["Czechia", "CZ", "Group A", "Czechia.png"],

    ["Canada", "CA", "Group B", "Canada.png"],
    ["Bosnia and Herzegovina", "BA", "Group B", "BosniaHerzegovina.png"],
    ["Qatar", "QA", "Group B", "Qatar.png"],
    ["Switzerland", "CH", "Group B", "Switzerland.png"],

    ["Brazil", "BR", "Group C", "Brazil.png"],
    ["Morocco", "MA", "Group C", "Morocco.png"],
    ["Haiti", "HT", "Group C", "Haiti.png"],
    ["Scotland", "SC", "Group C", "Scotland.png"],

    ["USA", "US", "Group D", "USA.png"],
    ["Paraguay", "PY", "Group D", "Paraguay.png"],
    ["Australia", "AU", "Group D", "Australia.png"],
    ["Turkey", "TR", "Group D", "Turkey.png"],

    ["Germany", "DE", "Group E", "Germany.png"],
    ["Curacao", "CW", "Group E", "Curacao.png"],
    ["Ivory Coast", "CI", "Group E", "IvoryCoast.png"],
    ["Ecuador", "EC", "Group E", "Ecuador.png"],

    ["Netherlands", "NL", "Group F", "Netherlands.png"],
    ["Japan", "JP", "Group F", "Japan.png"],
    ["Sweden", "SE", "Group F", "Sweden.png"],
    ["Tunisia", "TN", "Group F", "Tunisia.png"],

    ["Belgium", "BE", "Group G", "Belgium.png"],
    ["Egypt", "EG", "Group G", "Egypt.png"],
    ["Iran", "IR", "Group G", "Iran.png"],
    ["New Zealand", "NZ", "Group G", "NewZealand.png"],

    ["Spain", "ES", "Group H", "Spain.png"],
    ["Cape Verde", "CV", "Group H", "CapeVerde.png"],
    ["Saudi Arabia", "SA", "Group H", "SaudiArabia.png"],
    ["Uruguay", "UY", "Group H", "Uruguay.png"],

    ["France", "FR", "Group I", "France.png"],
    ["Senegal", "SN", "Group I", "Senegal.png"],
    ["Iraq", "IQ", "Group I", "Iraq.png"],
    ["Norway", "NO", "Group I", "Norway.png"],

    ["Argentina", "AR", "Group J", "Argentina.png"],
    ["Algeria", "DZ", "Group J", "Algeria.png"],
    ["Austria", "AT", "Group J", "Austria.png"],
    ["Jordan", "JO", "Group J", "Jordan.png"],

    ["Portugal", "PT", "Group K", "Portugal.png"],
    ["DR Congo", "CD", "Group K", "DRCongo.png"],
    ["Uzbekistan", "UZ", "Group K", "Uzbekistan.png"],
    ["Colombia", "CO", "Group K", "Colombia.png"],

    ["England", "EN", "Group L", "England.png"],
    ["Croatia", "HR", "Group L", "Croatia.png"],
    ["Ghana", "GH", "Group L", "Ghana.png"],
    ["Panama", "PA", "Group L", "Panama.png"],

];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->teams as $key => $team) {
            
            \App\Models\Team::factory()->create([
                'name' => $team[0],
                'short_name' => $team[1],
                'group_id' => $team[2],
                'flag' => $team[3],
            ]);
        }
    }
}
