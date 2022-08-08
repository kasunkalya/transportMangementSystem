<?php

namespace Sammy\TransportSupplier;

use Illuminate\Support\ServiceProvider;

class TransportSupplierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportSupplier');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportSupplier', function($app){
            return new TransportSupplier;
        });
    }
}
