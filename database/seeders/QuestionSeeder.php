<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    private $questions = [
        ["Have you used Popular Prediction to predict match results?", "2", "Yes,No"],
        ["Do you think popular Prediction is helpful in score prediction?", "2", "Yes,No"],
        ["Have you ever missed the first goal Prediction?", "2", "Yes,No"],
        ["Were you able to collect Player Cards?", "2", "Yes,No"],
        ["How easy were the rewards in helping you unlock countries?", "1", null],
        ["Did you enjoy earning cards and unlocking countries?", "2", "Yes,No"],
        ["How do you rate our App?", "1", null],
        ["Suggestions", "4", null],
    ];

    public function run(): void
    {
        // 1. Clear table first
        DB::table('questions')->truncate();

        // 2. Insert fresh data
        foreach ($this->questions as $question) {
            DB::table('questions')->insert([
                'question' => $question[0],
                'type'     => $question[1],
                'options'  => $question[2],
            ]);
        }
    }
}