<?php

namespace Modules\Admin\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(base_path('modules/Admin/resources/views'), 'admin');
        Paginator::defaultView('pagination::tailwind');
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ValidationProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }
}
