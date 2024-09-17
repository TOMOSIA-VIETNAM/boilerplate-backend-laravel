<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\Auth\LogoutController;
use Modules\Admin\Http\Controllers\LocalizationController;
use Modules\Admin\Http\Controllers\UserController;

Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang');

Route::middleware('guest:admin')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'login');
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return view('admin::welcome');
    })->name('home');

    Route::group([
        'prefix'        => 'user',
        'as'            => 'user.',
        'controller'    =>  UserController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post(uri: '/update/{id}', action: 'update')->name('update');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/delete/{id}', 'delete')->name('delete');
    });
});
