<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group([
        'middleware' => 'admin',
        'as' => 'dashboard.',
        'namespace' => 'Dashboard',
        'prefix' => 'dashboard'
    ], function () {
        Route::name('index')->get('/', 'PagesController@index');

        Route::name('trips.index')->get('trips', 'TripsController@index');
        Route::name('trips.create')->get('trips/create', 'TripsController@create');
        Route::name('trips.store')->post('trips', 'TripsController@store');
    });
    
    Route::group([
        'middleware' => 'customer',
        'as' => 'customer.',
        'namespace' => 'Customer',
    ], function () {
        Route::name('reservations.index')->get('reservations', 'ReservationsController@index');
        Route::name('reservations.create')->get('reservations/create', 'ReservationsController@create');
        Route::name('reservations.store')->post('reservations', 'ReservationsController@store');
    });
});