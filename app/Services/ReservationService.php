<?php

namespace App\Services;

use App\Models\City;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ReservationService
{
    /**
     * The departure city chosen by the customer
     *
     * @var int
     */
    protected $departureCity;

    /**
     * The arrival city chosen by the customer
     *
     * @var int
     */
    protected $arrivalCity;

    /**
     * Available departure stops in the city chosen by the customer
     *
     * @var array
     */
    protected $departureStops;

    /**
     * Initialize properties
     *
     * @param City $departureCity
     * @param City $arrivalCity
     */
    public function __construct(City $departureCity, City $arrivalCity)
    {
        $this->departureCity = $departureCity;
        $this->arrivalCity = $arrivalCity;
        $this->departureStops = Stop::whereCityId($this->departureCity->id)->get(); 
    }

    /**
     * Return the required seat data if any was found to make a reservation
     *
     * @return void
     */
    public function getSeat()
    {
        // If there are no departure stops available return null
        if (!count($this->departureStops)) {
            return null;
        }

        return $this->findSeat();
    }

    /**
     * Returns seat data by looping over the available departure stops
     * Then try to find an arrival stop matching the arrival city
     * Then get the trip reservations of the two stops
     * And finally finding a free seat by excluding reserved ones 
     *
     * @return mixed
     */
    protected function findSeat()
    {
        foreach ($this->departureStops as $departureStop) {
            $arrivalStop = $this->findArrivalStop($departureStop);
            if ($arrivalStop) {
                $reservations = $this->tripReservations($departureStop->trip, $departureStop);
                $seat = $this->freeSeat($departureStop->trip, $reservations);
                if ($seat) {
                    return ['seat' => $seat, 'departureStop' => $departureStop, 'arrivalStop' => $arrivalStop];
                }
            }
        }

        return null;
    }

    /**
     * Returns arrival stop that comes after the given departure
     * and in the arrival city
     *
     * @param Stop $departureStop
     * @return Stop
     */
    protected function findArrivalStop(Stop $departureStop)
    {
        return $departureStop->trip
            ->stops()
            ->where('city_id', $this->arrivalCity->id)
            ->where('order', '>', $departureStop->order)
            ->first();
    }

    /**
     * Returns the free seats in the trip
     *
     * @param Trip $trip
     * @param Collection $reservations
     * @return Seat
     */
    protected function freeSeat(Trip $trip, Collection $reservations)
    {
        return $trip->bus->seats()->whereNotIn('id', $reservations->pluck('seat_id')->toArray())->first();
    }

    /**
     * Return trip reservations where the arrival stop is before our departure
     *
     * @param Trip $trip
     * @param Stop $departureStop
     * @return Collection
     */
    protected function tripReservations(Trip $trip, Stop $departureStop)
    {
        return  Reservation::whereHas('seat', function(Builder $q) use($trip) {
            $q->whereBusId($trip->bus->id);
        })->whereHas('arrivalStop', function (Builder $q) use($trip, $departureStop) {
            $q->whereTripId($trip->id)->where('order', '>', $departureStop->order);
        })->get();
    }
}