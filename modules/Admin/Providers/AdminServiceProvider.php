<?php

namespace Modules\Admin\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        Blade::componentNamespace('Modules\\Admin\\View\\Components', 'admin');
        Paginator::useBootstrapFive();
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }
}
