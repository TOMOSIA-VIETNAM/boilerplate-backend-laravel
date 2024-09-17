<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\LocalizationController;
use Modules\Admin\Http\Controllers\UserController;

Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang');

Route::get('/', function () {
    return view('admin::welcome');
});
Route::get('/login', function () {
    return view('admin::auth.login');
});


Route::group([
    'prefix'        => 'user',
    'as'            => 'user.',
    'controller'    =>  UserController::class,
], function () {
    Route::get('/', 'index')->name('index');
});
