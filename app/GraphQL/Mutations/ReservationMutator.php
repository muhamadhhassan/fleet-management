<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\NoReservationException;
use App\Http\Resources\ReservationResource;
use App\Models\City;
use App\Services\ReservationService;

class ReservationMutator
{
    public function create($_, $args)
    {
        $departureCity = City::find($args['departureCityId']);
        $arrivalCity = City::find($args['arrivalCityId']);
        $reservationService = new ReservationService($departureCity, $arrivalCity);
        $seatData = $reservationService->getSeat();

        if(!$seatData) {
            throw new NoReservationException('No available seats between these two cities');
        }
        
        $reservation = auth()->user()->reservations()->create([
            'seat_id' => $seatData['seat']->id,
            'departure_stop_id' => $seatData['departureStop']->id,
            'arrival_stop_id' => $seatData['arrivalStop']->id,
        ]);
        
        return new ReservationResource($reservation);
    }
}
