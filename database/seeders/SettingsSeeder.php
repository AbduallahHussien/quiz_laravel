<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            'name' => 'title',
            'value' => 'Artist',
        ]);
        \DB::table('settings')->insert([
            'name' => 'logo',
            'value' => 'logo.png',
        ]);
        \DB::table('settings')->insert([
            'name' => 'footer',
            'value' => 'Made By GoodAbilities',
        ]);
        \DB::table('settings')->insert([
            'name' => 'language',
            'value' => 'en',
        ]);
    }
}
