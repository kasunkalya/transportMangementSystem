<?php

namespace Sammy\TransportLorryChargers;

use Illuminate\Support\ServiceProvider;

class TransportLorryChargersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLorryChargers');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLorryChargers', function($app){
            return new TransportLorryChargers;
        });
    }
}
