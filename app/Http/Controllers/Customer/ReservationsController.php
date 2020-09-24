<?php

namespace App\Http\Controllers\Customer;

use App\Models\City;
use App\Models\Seat;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use App\Http\Requests\ReservationRequest;
use Illuminate\Database\Eloquent\Builder;

class ReservationsController extends Controller
{

    /**
     * Returns all reservations of the authenticated user.
     *
     * @return void
     */
    public function index()
    {
        $reservations = auth()->user()->reservations->load('departureStop.city', 'arrivalStop.city');

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Returns reservations create page.
     *
     * @return void
     */
    public function create()
    {
        $cities = City::orderBy('name')->pluck('name', 'id');

        return view('reservations.create', compact('cities'));
    }

    /**
     * Stores a new reservation.
     *
     * @param ReservationRequest $request
     * @return void
     */
    public function store(ReservationRequest $request)
    {
        $departureCity = City::find($request->get('departure_stop_id'));
        $arrivalCity = City::find($request->get('arrival_stop_id'));
        $reservationService = new ReservationService($departureCity, $arrivalCity);
        $seatData = $reservationService->getSeat();

        if(!$seatData) {
            return redirect()->route('customer.reservations.create')->with('error', 'No available seats between these two cities');
        }
        
        auth()->user()->reservations()->create([
            'seat_id' => $seatData['seat']->id,
            'departure_stop_id' => $seatData['departureStop']->id,
            'arrival_stop_id' => $seatData['arrivalStop']->id,
        ]);
        
        return redirect()->route('customer.reservations.index')->with('success', 'Your seat is booked successfully');
    }
}
