<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\ValidationException;
use App\Http\Resources\TripResource;
use App\Models\Bus;
use Illuminate\Support\Facades\Validator;

class TripMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function create($_, array $args)
    {
        $this->validateArgs($args);
        
        if (! $bus = Bus::find($args['bus_id'])) {
            abort(404, 'Bus not Found');
        }

        $trip = $bus->trips()->create();
        foreach ($args['stops'] as $key => $stop) {
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
            'stops.*.city_id' => 'required|exists:cities,id',
            'stops.*.order' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('The given data was invalid', $validator->errors()->messages());
        }
    }
}
