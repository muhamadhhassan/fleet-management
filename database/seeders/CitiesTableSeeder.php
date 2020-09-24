<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitiesTableSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('cities');

        $cities = [
            'Alexandria',
            'Aswan',
            'Asyut',
            'Beheira',
            'Beni Suef',
            'Cairo',
            'Dakahlia',
            'Damietta',
            'Faiyum',
            'Gharbia',
            'Giza',
            'Ismailia',
            'Kafr El Sheikh',
            'Luxor',
            'Matruh',
            'Minya',
            'Monufia',
            'New Valley',
            'North Sinai',
            'Port Said',
            'Qalyubia',
            'Qena',
            'Red Sea',
            'Sharqia',
            'Sohag',
            'South Sinai',
            'Suez'
        ];

        foreach ($cities as $city) {
            City::create(['name' => $city, 'slug' => Str::slug($city)]);
        }
    }
}
