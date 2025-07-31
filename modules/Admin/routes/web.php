<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AuthController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web'])
    ->group(function () {
        // Language switching route
        Route::get('/lang/{locale}', function ($locale) {
            if (in_array($locale, ['en', 'ja'])) {
                session(['locale' => $locale]);
            }
            return redirect()->back();
        })->name('lang.switch');
    });
