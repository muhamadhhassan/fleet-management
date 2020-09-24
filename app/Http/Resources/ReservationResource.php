<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'departureStop' => new StopResource($this->departureStop),
            'arrivalStop' => new StopResource($this->arrivalStop),
            'seat' => new SeatResource($this->seat),
        ];
    }
}
