<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Language switching route
        Route::get('/lang/{locale}', function ($locale) {
            if (in_array($locale, ['en', 'ja'])) {
                session(['locale' => $locale]);
                app()->setLocale($locale);
            }
            return redirect()->back();
        })->name('lang.switch');
    });

