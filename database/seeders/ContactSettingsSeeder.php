<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('settings')->insert([
            'name' => 'address',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'email',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'phone',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'altitude',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'longitude',
            'value' => '',
        ]); 
        
    }
}
