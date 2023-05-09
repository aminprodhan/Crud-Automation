<?php

namespace Aminpciu\CrudAutomation\app\Providers;
use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
use Aminpciu\CrudAutomation\app\Interfaces\CrudApiInterface;
use Aminpciu\CrudAutomation\app\Middleware\CrudAutomationMiddleware;
use Aminpciu\CrudAutomation\app\Repository\DynamicCrudRepository;
use Illuminate\Support\ServiceProvider;

class DynamicCrudProvider extends ServiceProvider
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
        //php artisan vendor:publish --tag=config
        $this->publishes([
            __DIR__.'/../../public' => public_path('aminpciu/crudautomation'),
        ], 'public');
        $this->app['router']->aliasMiddleware('crud-automation-middleware', CrudAutomationMiddleware::class);
        $middlwares=CommonTrait::getCustomMiddlewares(1);
        if(count($middlwares) > 0)
            $this->app['router']->middlewareGroup('aminpciu-package-middleware-group', $middlwares);
        $this->app->bind(CrudApiInterface::class,DynamicCrudRepository::class);
    }
}
