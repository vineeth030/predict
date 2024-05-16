<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    private $teams = [
        ["Germany", "DE","Group A","Germany.png"],
        ["Scotland", "FR","Group A","Scotland.png"],
        ["Hungary", "IT","Group A","Hungary.png"],
        ["Switzerland", "EN","Group A","Switzerland.png"],

        ["Spain", "ES","Group B","Spain.png"],
        ["Croatia", "PT","Group B","Croatia.png"],
        ["Italy", "BE","Group B","Italy.png"],
        ["Albania", "NL","Group B","Albania.png"],

        ["Slovenia", "DK","Group C","Slovenia.png"],
        ["Denmark", "CH","Group C","Denmark.png"],
        ["Serbia", "HR","Group C","Serbia.png"],
        ["England", "SC","Group C","England.png"],

        ["Poland", "HU","Group D","Poland.png"],
        ["Netherlands", "AT","Group D","Netherlands.png"],
        ["Austria", "AL","Group D","Austria.png"],
        ["France", "SK","Group D","France.png"],
      
        ["Belgium", "HU","Group E","Belgium.png"],
        ["Slovakia", "AT","Group E","Slovakia.png"],
        ["Romania", "AL","Group E","Romania.png"],
        ["Ukraine", "SK","Group E","Ukraine.png"],

        ["Turkey", "HU","Group F","Turkey.png"],
        ["Georgia", "AT","Group F","Georgia.png"],
        ["Portugal", "AL","Group F","Portugal.png"],
        ["Czechia", "SK","Group F","Czechia.png"],
        
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

            ]);
        }
    }
}
