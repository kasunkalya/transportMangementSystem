<?php

namespace Sammy\TransportLorryRepair;

use Illuminate\Support\ServiceProvider;

class TransportLorryRepairServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLorryRepair');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLorryRepair', function($app){
            return new TransportLorryRepair;
        });
    }
}
