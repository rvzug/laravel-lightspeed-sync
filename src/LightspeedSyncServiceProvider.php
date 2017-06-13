<?php

namespace Rvzug\LightspeedSync;

use \Illuminate\Support\ServiceProvider as ServiceProvider;

class VoyagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
    * Register the application services.
    */
    public function register()
    {
        $this->app->singleton(LightspeedSync::class, function ($app) {
            return new LightspeedSync();
        });

        $this->app->alias(LightspeedSync::class, 'lightspeedsync');
    }
}