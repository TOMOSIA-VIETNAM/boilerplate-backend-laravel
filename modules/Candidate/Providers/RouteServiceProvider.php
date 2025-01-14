<?php

namespace Modules\Candidate\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function map(): void
    {
        $this->mapAdminRoutes();
    }

    /**
     * @return void
     */
    protected function mapAdminRoutes(): void
    {
        Route::prefix('candidate')
            ->middleware('web')
            ->as('candidate.')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
    }
}
