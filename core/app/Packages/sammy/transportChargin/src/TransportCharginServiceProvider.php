<?php

namespace Sammy\TransportChargin;

use Illuminate\Support\ServiceProvider;

class TransportCharginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportChargin');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportChargin', function($app){
            return new TransportChargin;
        });
    }
}
