<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('12345678'),
            'phone' => '1234567890',
            'address' => 'Saket Nagar',
            'city' => 'Delhi',
            'country' => 'India',
            'about_me' => 'IT Industry',
            'role'=> 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // DB::table('users')->insert([
        //     'id' => 2,
        //     'name' => 'student',
        //     'email' => 'student@demo.com',
        //     'password' => Hash::make('12345678'), 
        //     'phone' => '1234567890', 
        //     'location' => 'Some Location', 
        //     'city' => 'Some City', 
        //     'country' => 'Some Country', 
        //     'about_me' => 'This is a student.', 
        //     'role' => 'student', 
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
