<?php

namespace App\GraphQL\Mutations;

use App\Models\City;
use App\Services\ReservationService;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\NoReservationException;
use App\Http\Resources\ReservationResource;

class ReservationMutator
{
    public function create($_, $args)
    {
        $this->validateArgs($args);
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

    protected function validateArgs($args)
    {
        $validator = Validator::make($args, [
            'departureCityId' => 'required|exists:cities,id|different:arrivalCityId',
            'arrivalCityId' => 'required|exists:cities,id|different:departureCityId',
        ], [
            'departureCityId.different' => 'A city can be added once',
            'arrivalCityId.different' => 'A city can be added once',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('The given data was invalid', $validator->errors()->messages());
        }
    }
}
