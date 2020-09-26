<?php

namespace App\GraphQL\Queries;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;

class ReservationsQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user = auth()->user();
        if (! $user->is_admin) {
            return ReservationResource::collection($user->reservations()->with('seat.bus', 'departureStop.city', 'arrivalStop.city')->get());
        }

        return ReservationResource::collection(Reservation::orderBy('created_at')->get());
    }
}
