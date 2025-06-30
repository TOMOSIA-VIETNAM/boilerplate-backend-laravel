<?php

namespace Modules\Admin\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Http\Middleware\Authenticate;
use Illuminate\Contracts\Container\BindingResolutionException;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(base_path('modules/Admin/resources/views'), 'admin');
        Paginator::useBootstrapFive();
        $this->registerMiddleware();
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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

    /**
     * Register middleware.
     */
    protected function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('auth.admin', Authenticate::class);
    }
}
