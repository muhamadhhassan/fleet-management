<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * This service provider help the ide recognize the facades.
         */
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Check if the authenticated user is admin
         */
        Blade::if('admin', function () {
            return optional(auth()->user())->is_admin;
        });

        /**
         * Check if the authenticated user is a customer
         */
        Blade::if('customer', function () {
            return auth()->check() && !auth()->user()->is_admin;
        });
    }
}
