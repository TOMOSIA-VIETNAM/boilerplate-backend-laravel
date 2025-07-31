<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    /**
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Configure auth middleware to use admin login route
        config(['auth.defaults.guard' => 'web']);
        config(['auth.defaults.passwords' => 'users']);
        config(['auth.guards.web.driver' => 'session']);
        config(['auth.guards.web.provider' => 'users']);
        
        // Set the login route for the auth middleware
        config(['auth.routes.login' => 'admin.login']);
        config(['auth.routes.logout' => 'admin.logout']);
        
        Route::pattern('id', '[0-9]+');
    }
}
