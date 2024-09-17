<?php

namespace Modules\Admin\Providers;

use App\Enums\LangEnum;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register global params for all views.
     */
    public function boot(): void
    {
        View::composer('admin::*', function ($view) {
            $data = [
                'langs' => LangEnum::ALLOW_LOCALES,
                'currentFlag' => getFlagByLocale(config('app.locale'))
            ];

            $view->with($data);
        });
    }
}
