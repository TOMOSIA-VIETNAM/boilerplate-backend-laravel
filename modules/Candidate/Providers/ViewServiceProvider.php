<?php

namespace Modules\Candidate\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register global params for all views.
     */
    public function boot(): void
    {
        View::composer('candidate::*', function ($view) {
            $data = [];

            $view->with($data);
        });
    }
}
