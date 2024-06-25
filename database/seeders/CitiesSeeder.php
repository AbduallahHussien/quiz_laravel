<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'Cairo',
            'Alexandria',
            'Giza',
            'Shubra El-Kheima',
            'Port Said',
            'Suez',
            'Luxor',
            'Mansoura',
            'Tanta',
            'Asyut',
            'Fayoum',
            'Zagazig',
            'Ismailia',
            'Aswan',
            'Damietta',
            'Minya',
            'Beni Suef',
            'Sohag',
            'Qena',
            'Hurghada'
        ];
        foreach($cities as $city){
            \DB::table('cities')->insert(
                [
                'name' => $city
                ],
            );
        }
    }
}
