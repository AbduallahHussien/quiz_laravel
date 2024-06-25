<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewModulesSeeder extends Seeder
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
            'name' => 'customers',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'categories',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'themes',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'styles',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'colors',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'locations',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'paintings',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'addons',
            ],
        );
        \DB::table('modules')->insert(
            [
            'name' => 'certificates',
            ],
        );
    }
}
