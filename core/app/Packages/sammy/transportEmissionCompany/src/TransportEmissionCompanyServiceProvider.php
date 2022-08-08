<?php

namespace Sammy\TransportEmissionCompany;

use Illuminate\Support\ServiceProvider;

class TransportEmissionCompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportEmissionCompany');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportEmissionCompany', function($app){
            return new TransportEmissionCompany;
        });
    }
}
