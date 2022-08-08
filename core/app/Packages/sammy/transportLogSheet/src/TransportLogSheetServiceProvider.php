<?php

namespace Sammy\TransportLogSheet;

use Illuminate\Support\ServiceProvider;

class TransportLogSheetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportLogSheet');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportLogSheet', function($app){
            return new TransportLogSheet;
        });
    }
}
