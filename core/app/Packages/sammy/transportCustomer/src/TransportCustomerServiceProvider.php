<?php

namespace Sammy\TransportCustomer;

use Illuminate\Support\ServiceProvider;

class TransportCustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportCustomer');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportCustomer', function($app){
            return new TransportCustomer;
        });
    }
}
