<?php

namespace Modules\Api\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ValidationProvider::class);
    }
} 