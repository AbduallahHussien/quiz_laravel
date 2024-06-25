<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            'name' => 'facebook',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'twitter',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'pinterest',
            'value' => '',
        ]);
    }
}
