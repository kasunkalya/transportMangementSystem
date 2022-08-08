<?php

namespace Sammy\TransportDocument;

use Illuminate\Support\ServiceProvider;

class TransportDocumentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'transportDocument');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('transportDocument', function($app){
            return new TransportDocument;
        });
    }
}
