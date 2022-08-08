<?php

namespace Sammy\TransportLorryMaintain;

use Illuminate\Support\ServiceProvider;

class TransportLorryMaintainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLorryMaintain');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLorryMaintain', function($app){
            return new TransportLorryMaintain;
        });
    }
}
