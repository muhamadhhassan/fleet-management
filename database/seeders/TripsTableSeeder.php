<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\City;
use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('reservations');
        $this->truncate('stops');
        $this->truncate('trips');

        $bus = Bus::whereDoesntHave('trips')->first();
        if (!$bus) {
            return;
        }
        
        $trip = $bus->trips()->create();
        $stops = ['cairo', 'giza', 'faiyum', 'minya', 'asyut'];
        foreach ($stops as $key => $stop) {
            $trip->stops()->create(['city_id' => City::whereSlug($stop)->first()->id, 'order' => $key + 1]);
        }
    }
}
