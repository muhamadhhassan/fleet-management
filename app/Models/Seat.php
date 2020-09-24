<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['bus_id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Returns the nus of the seat.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
