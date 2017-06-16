<?php

namespace Rvzug\LightspeedSync;

use \Illuminate\Support\ServiceProvider as ServiceProvider;
use Rvzug\LightspeedSync\Commands\LightspeedSyncCommand;

class LightspeedSyncServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations/');
        $this->commands([LightspeedSyncCommand::class]);
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