<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(Roles_Permissions::class);
        $this->call(SettingsSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(NewModulesSeeder::class);
        $this->call(ArtistsModulesSeeder::class);
        $this->call(VendorModuleSeeder::class);

        $this->call(AssetsModuleSeeder::class);
        $this->call(ContactSettingsSeeder::class);
        $this->call(CouponsModuleSeeder::class);
        $this->call(CoursesModuleSeeder::class);
        $this->call(NewKeysSettingsSeeder::class);
        $this->call(PagesModuleSeeder::class);
        $this->call(PostsModuleSeeder::class);
        $this->call(PurchaseOrdersModuleSeeder::class);
        $this->call(ReturnsModuleSeeder::class);
        $this->call(RoomsModuleSeeder::class);
        $this->call(SalesOrdersModuleSeeder::class);
        $this->call(SlidesModuleSeeder::class);
        $this->call(SocialSettingsSeeder::class);
        $this->call(SuppliersModuleSeeder::class);
        $this->call(updateSetting28_5Seeder::class);
        $this->call(updateSetting31_5Seeder::class);

        
        
        
        
        
        
        
        
    }
}
