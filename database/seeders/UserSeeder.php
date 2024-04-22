<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Predict',
            'designation' => 'Web Developer',
            'email' => 'admin@predict.com',
            'employee_id' => 28,
            'image' => '28_photo.jpg',
            'company_group_id' => 2,
            'password' => 'password',
            'is_admin' => true
        ]);

        \App\Models\User::factory(10)->create();
    }
}
