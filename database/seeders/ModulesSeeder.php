<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('modules')->insert(
            [
            'name' => 'users',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'permissions',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'settings',
            ],
        );
     

       
    }
}
