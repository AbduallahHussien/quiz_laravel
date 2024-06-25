<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        \DB::table('permissions')->insert(
            [
            'name' => 'add',
            
            ],
        );

        \DB::table('permissions')->insert(
            [
            'name' => 'edit',
            
            ],
        );

        \DB::table('permissions')->insert(
            [
            'name' => 'delete',
         ],
        );

        \DB::table('permissions')->insert(
            [
            'name' => 'view',
            
            ],
        );
    }
}
