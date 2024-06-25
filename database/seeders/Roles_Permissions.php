<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roles_Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles_permissions')->insert(
            [
            'permission_id' => 1,
            'role_id' => 1,
            'module_id' => 1,
            ]
            );
        \DB::table('roles_permissions')->insert(
            [
                'permission_id' => 2,
                'role_id' => 1,
                'module_id' => 1,
            ]
        );  
        \DB::table('roles_permissions')->insert(
            [
                'permission_id' => 3,
                'role_id' => 1,
                'module_id' => 1,
            ]
        );  
        \DB::table('roles_permissions')->insert(
            [
                'permission_id' => 4,
                'role_id' => 1,
                'module_id' => 1,
            ]
        );   
        \DB::table('roles_permissions')->insert(
            [
                'permission_id' => 4,
                'role_id' => 1,
                'module_id' => 2,
            ]
        );   

      
    }
}
