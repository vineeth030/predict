<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Version::factory()->create([
            'platform' => 'ios',
            'code' => '1',
            'name' => '1.0.0',
            'is_mandatory' => '0',
            'is_quarter_started' => '0',
            'countdown_timer' => '1781204400000',
            'is_round16_completed' => '0',
            'wc_end_date' => '1786474800000',
            'winner' => 'England'
        ]);


        \App\Models\Version::factory()->create([
            'platform' => 'android',
            'code' => '1',
            'name' => '1.0.0',
            'is_mandatory' => '0',
            'is_quarter_started' => '0',
            'countdown_timer' => '1781204400000',
            'is_round16_completed' => '0',
            'wc_end_date' => '1786474800000',
            'winner' => 'England'
        ]);

      

    }
}
