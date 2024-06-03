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
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => true,
            'verified' => 1
        ]);


        \App\Models\User::factory()->create([
            'name' => 'Test Android1',
            'designation' => 'Web Developer',
            'email' => 'test@beo.in',
            'employee_id' => 28,
            'image' => '28_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Android2',
            'designation' => 'Web Developer',
            'email' => 'test@beo.in',
            'employee_id' => 28,
            'image' => '28_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test iOS1',
            'designation' => 'Web Developer',
            'email' => 'test@beo.in',
            'employee_id' => 28,
            'image' => '28_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test iOS2',
            'designation' => 'Web Developer',
            'email' => 'test@beo.in',
            'employee_id' => 28,
            'image' => '28_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        //\App\Models\User::factory(10)->create();
    }
}
