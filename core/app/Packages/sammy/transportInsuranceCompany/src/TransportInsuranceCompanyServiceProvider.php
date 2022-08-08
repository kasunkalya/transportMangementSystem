<?php

namespace Sammy\TransportInsuranceCompany;

use Illuminate\Support\ServiceProvider;

class TransportInsuranceCompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportInsuranceCompany');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportInsuranceCompany', function($app){
            return new TransportInsuranceCompany;
        });
    }
}
