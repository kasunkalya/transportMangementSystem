<?php

namespace Sammy\TransportManagement;

use Illuminate\Support\ServiceProvider;

class TransportManagementServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportManagement');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportManagement', function($app){
            return new TransportManagement;
        });
    }
}
