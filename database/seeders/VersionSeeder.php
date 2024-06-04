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
            'platform' => 'android',
            'code' => 'a',
            'name' => 'a',
            'is_mandatory' => '0',
            'is_quarter_started' => '0',
            'countdown_timer' => '1718391600000',
            'is_round16_completed' => '0',
            'wc_end_date' => '1723662000000',
            'winner' => 'England'
        ]);

        \App\Models\Version::factory()->create([
            'platform' => 'ios',
            'code' => 'a',
            'name' => 'a',
            'is_mandatory' => '0',
            'is_quarter_started' => '0',
            'countdown_timer' => '1718391600000',
            'is_round16_completed' => '0',
            'wc_end_date' => '1723662000000',
            'winner' => 'England'
        ]);

    }
}
