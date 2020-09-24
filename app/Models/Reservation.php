<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['seat_id', 'user_id', 'departure_stop_id', 'arrival_stop_id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Returns the user who made the reservation
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the seat of the reservation
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Returns Departure Stop
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departureStop()
    {
        return $this->belongsTo(Stop::class, 'departure_stop_id');
    }

    /**
     * Returns arrival stop
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arrivalStop()
    {
        return $this->belongsTo(Stop::class, 'arrival_stop_id');
    }
}
