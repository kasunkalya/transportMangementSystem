<?php

namespace Sammy\TransportCompany;

use Illuminate\Support\ServiceProvider;

class TransportCompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportCompany');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportCompany', function($app){
            return new TransportCompany;
        });
    }
}
