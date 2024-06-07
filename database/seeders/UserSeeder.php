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
            'designation' => 'Android Developer',
            'email' => 'test@beo.in',
            'employee_id' => 30,
            'image' => '30_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Android2',
            'designation' => 'Android Developer',
            'email' => 'test@beo.in',
            'employee_id' => 31,
            'image' => '31_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test iOS1',
            'designation' => 'ios Developer',
            'email' => 'test@beo.in',
            'employee_id' => 32,
            'image' => '32_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test iOS2',
            'designation' => 'ios Developer',
            'email' => 'test@beo.in',
            'employee_id' => 33,
            'image' => '33_photo.jpg',
            'company_group_id' => 0,
            'password' => 'password',
            'is_admin' => false,
            'verified' => 1
        ]);
        //\App\Models\User::factory(10)->create();
    }
}
