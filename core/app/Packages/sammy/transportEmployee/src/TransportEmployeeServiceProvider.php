<?php

namespace Sammy\TransportEmployee;

use Illuminate\Support\ServiceProvider;

class TransportEmployeeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportEmployee');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportEmployee', function($app){
            return new TransportEmployee;
        });
    }
}
