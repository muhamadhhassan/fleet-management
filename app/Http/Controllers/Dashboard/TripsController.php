<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Http\Resources\CityResource;
use App\Models\Bus;
use App\Models\City;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * Returns all the trips.
     *
     * @return void
     */
    public function index()
    {
        $trips = Trip::with('bus.seats', 'stops')->get();

        return view('dashboard.trips.index', compact('trips'));
    }

    /**
     * Returns a page to create new trip
     *
     * @return void
     */
    public function create()
    {
        $buses = Bus::whereDoesntHave('trips')->get()->pluck('plate_number', 'id');
        $cities = CityResource::collection(City::orderBy('name')->get());

        return view('dashboard.trips.create', compact('buses', 'cities'));
    }

    /**
     * Stores new trip
     *
     * @param TripRequest $request
     * @return void
     */
    public function store(TripRequest $request)
    {
        $bus = Bus::findOrFail($request->get('bus_id'));
        $trip = $bus->trips()->create();
        foreach ($request->get('stops') as $key => $stop) {
            $trip->stops()->create(['city_id' => $stop, 'order' => $key + 1]);
        }

        return redirect()->route('dashboard.trips.create')->with('success', 'Trip was added successfully');
    }
}
