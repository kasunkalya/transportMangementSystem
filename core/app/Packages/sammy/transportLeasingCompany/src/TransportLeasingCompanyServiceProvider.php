<?php

namespace Sammy\TransportLeasingCompany;

use Illuminate\Support\ServiceProvider;

class TransportLeasingCompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLeasingCompany');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLeasingCompany', function($app){
            return new TransportLeasingCompany;
        });
    }
}
