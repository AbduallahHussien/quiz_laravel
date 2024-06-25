<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class updateSetting28_5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            'name' => 'public_logo',
            'value' => '',
        ]);
        \DB::table('settings')->insert([
            'name' => 'qr_logo',
            'value' => '',
        ]);

        \DB::table('settings')->insert([
            'name' => 'terms_page',
            'value' => '',
        ]);
       
    }
}
