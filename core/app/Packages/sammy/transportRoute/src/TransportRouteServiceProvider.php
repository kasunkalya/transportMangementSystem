<?php

namespace Sammy\TransportRoute;

use Illuminate\Support\ServiceProvider;

class TransportRouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportRoute');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportRoute', function($app){
            return new TransportRoute;
        });
    }
}
