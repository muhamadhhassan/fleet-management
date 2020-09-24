<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('departure_stop_id')->constrained('stops');
            $table->foreignId('arrival_stop_id')->constrained('stops');
            $table->timestamps();

            $table->unique(['seat_id', 'departure_stop_id', 'arrival_stop_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
