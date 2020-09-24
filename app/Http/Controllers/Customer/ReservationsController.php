<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\City;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

        $departures = Stop::whereCityId($departureCity->id)->get();
        if(!count($departures)) {
            return redirect()->route('customer.reservations.create')->with('error', 'No trips are leaving from the selected city');
        }

        foreach ($departures as $departure) {
            $arrivalStop = $this->tripToDestination($departure, $arrivalCity);
            if ($arrivalStop) {
                $seat = $this->availableSeat($departure->trip, $departure);
                if ($seat) {
                    auth()->user()->reservations()->create([
                        'seat_id' => $seat->id,
                        'departure_stop_id' => $departure->id,
                        'arrival_stop_id' => $arrivalStop->id,
                    ]);

                    return redirect()->route('customer.reservations.index')->with('success', 'Your seat is booked successfully');
                }
            }
        }

        return redirect()->route('customer.reservations.create')->with('error', 'No trips are travelling to the selected city');
    }

    /**
     * Return the possible arrival stop for a given departure point and city.
     *
     * @param Stop $departureStop
     * @param City $arrivalCity
     * @return Stop
     */
    protected function tripToDestination(Stop $departureStop, City $arrivalCity)
    {
        return $departureStop->trip
            ->stops()
            ->where('city_id', $arrivalCity->id)
            ->where('order', '>', $departureStop->order)
            ->first();
    }

    /**
     * Returns an empty seat for in a trip by excluding the already booked seats.
     *
     * @param Trip $trip
     * @param Stop $departureStop
     * @return Seat
     */
    protected function availableSeat(Trip $trip, Stop $departureStop)
    {
        $bookedSeats = Reservation::whereHas('seat', function(Builder $q) use($trip) {
            $q->whereBusId($trip->bus->id);
        })->whereHas('arrivalStop', function (Builder $q) use($trip, $departureStop) {
            $q->whereTripId($trip->id)->where('order', '>', $departureStop->order);
        })->get(['seat_id']);
        
        return $trip->bus->seats()->whereNotIn('id', $bookedSeats)->first();
    }
}
