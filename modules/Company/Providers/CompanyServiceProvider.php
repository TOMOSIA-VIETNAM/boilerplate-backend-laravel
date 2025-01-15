<?php

namespace Modules\Company\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(base_path('modules/Company/resources/views'), 'company');
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
