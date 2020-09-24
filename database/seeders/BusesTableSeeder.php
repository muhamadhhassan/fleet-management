<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Database\Factories\SeatFactory;
use Illuminate\Database\Seeder;

class BusesTableSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('buses');

        Bus::factory(10)
            ->has(Seat::factory()->count(12))
            ->create();
    }
}
