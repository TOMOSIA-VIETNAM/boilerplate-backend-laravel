<?php

use Modules\Api\Http\Controllers\AuthController;
use Modules\Api\Http\Controllers\UserController;
use Modules\Api\Http\Controllers\UserAvatarController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api'],
    'namespace' => 'Modules\Api\Http\Controllers'
], function () {
    // Auth Routes
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    // User Management Routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
            Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            
            // Avatar Routes
            Route::post('/{id}/avatar', [UserAvatarController::class, 'upload'])->name('users.avatar.upload');
            Route::delete('/{id}/avatar', [UserAvatarController::class, 'delete'])->name('users.avatar.delete');
        });
    });
}); 