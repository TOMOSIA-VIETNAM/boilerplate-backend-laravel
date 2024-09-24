<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\AuthController;
use Modules\Api\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'controller' => AuthController::class
], function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')
        ->middleware('auth:sanctum')
        ->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group([
        'prefix' => 'profile',
        'controller' => UserController::class,
        'as' => 'user.'
    ], function () {
        Route::get('', 'profile')->name('profile');
        Route::post('update', 'update')->name('update');
        Route::post('change_password', 'changePassword')->name('change-password');
    });
});
