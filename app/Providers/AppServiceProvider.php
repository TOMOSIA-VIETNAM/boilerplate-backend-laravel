<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Providers\AdminServiceProvider;
use Modules\Candidate\Providers\CandidateServiceProvider;
use Modules\Company\Providers\CompanyServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(CandidateServiceProvider::class);
        $this->app->register(CompanyServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
