<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewKeysSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            'name' => 'who_are_you',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'our_vision',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'our_mission',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'our_values',
            'value' => '',
        ]);
    }
}
