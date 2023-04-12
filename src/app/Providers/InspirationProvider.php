<?php

namespace Aminpciu\CrudAutomation\app\Providers;

use Illuminate\Support\ServiceProvider;

class InspirationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../views', 'lca-amin-pciu');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        //php artisan vendor:publish --tag=public --force
        $this->publishes([
            __DIR__.'/../../public' => public_path('aminpciu/crudautomation'),
        ], 'public');
    }
}
