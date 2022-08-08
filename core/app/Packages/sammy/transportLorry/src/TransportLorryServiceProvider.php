<?php

namespace Sammy\TransportLorry;

use Illuminate\Support\ServiceProvider;

class TransportLorryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLorry');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLorry', function($app){
            return new TransportLorry;
        });
    }
}
