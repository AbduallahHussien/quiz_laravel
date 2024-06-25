<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'phone' => '01552134570',
            'email' => 'admin@artist.com',
            'password' => \Hash::make('123456'),
            'role_id' => 1
        ]);

        \DB::table('users')->insert([
            'name' => 'User',
            'username' => 'user',
            'phone' => '015555555',
            'email' => 'user@artist.com',
            'password' => \Hash::make('user@123'),
            'role_id' => 2
        ]);
    }
}
