<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $questions = [
        ["Have you used Popular Prediction to predict match results?","2","Yes,No"],
        ["Do you think popular  Prediction is helpful in score prediction?","2","Yes,No"],
        ["Have you ever missed the first goal Prediction?","2","Yes,No"],
        ["Were you able to collect Player Coupon?","2","Yes,No"],
        ["How easy were the Questions to unlock the Coupons","1",null],
        ["Did you enjoy earning stars from unlocking Coupons?","2","Yes,No"],
        ["How do you rate our App","1",null],
        ["Suggestions","4",null],
       

        
    ];
    public function run(): void
    {
        foreach ($this->questions as $key => $question) {
            
            DB::table('questions')-> insert([
                'question' => $question[0],
                'type' =>$question[1],
                'options' =>$question[2],

            ]);
        }
    }
}
