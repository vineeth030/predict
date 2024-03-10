<?php

namespace Database\Seeders;

use Database\Factories\PredictionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Prediction::factory()->create([
            //
        ]);
    }
}
