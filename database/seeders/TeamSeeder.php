<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    private $teams = [
        ["Germany", "DE"],
        ["France", "FR"],
        ["Italy", "IT"],
        ["England", "EN"],
        ["Spain", "ES"],
        ["Portugal", "PT"],
        ["Belgium", "BE"],
        ["Netherlands", "NL"],
        ["Denmark", "DK"],
        ["Switzerland", "CH"],
        ["Croatia", "HR"],
        ["Scotland", "SC"],
        ["Hungary", "HU"],
        ["Austria", "AT"],
        ["Slovakia", "SK"],
        ["Albania", "AL"],
        ["Czechia", "CZ"],
        ["Slovenia", "SI"],
        ["Romania", "RO"],
        ["Serbia", "RS"],
        ["Poland", "PL"],
        ["Turkey", "TR"],
        ["North Macedonia", "MK"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->teams as $key => $team) {
            
            \App\Models\Team::factory()->create([
                'name' => $team[0],
                'short_name' => $team[1]
            ]);
        }
    }
}
