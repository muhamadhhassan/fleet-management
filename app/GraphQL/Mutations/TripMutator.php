<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\ValidationException;
use App\Http\Resources\TripResource;
use App\Models\Bus;
use Illuminate\Support\Facades\Validator;

class TripMutator
{
    public function create($_, array $args)
    {
        $this->validateArgs($args);
        
        if (! $bus = Bus::find($args['bus_id'])) {
            abort(404, 'Bus not Found');
        }

        $trip = $bus->trips()->create();
        foreach ($args['stops'] as $stop) {
            $trip->stops()->create([
                'city_id' => $stop['city_id'],
                'order' => $stop['order']
            ]);
        }

        return new TripResource($trip);
    }

    protected function validateArgs($args)
    {
        $validator = Validator::make($args, [
            'bus_id' => 'required|exists:buses,id',
            'stops.*.city_id' => 'required|exists:cities,id|distinct',
            'stops.*.order' => 'required|numeric|min:1|distinct',
        ], [
            'stops.*.city_id.distinct' => 'A city can be added once',
            'stops.*.order.distinct' => 'Two cities has the same order',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('The given data was invalid', $validator->errors()->messages());
        }
    }
}
