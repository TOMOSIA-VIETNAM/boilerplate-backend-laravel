<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\UserAvatarController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\BlogController;

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

// Route::group([
//     'prefix' => 'admin',
//     'middleware' => ['web'],
//     'namespace' => 'Modules\Admin\Http\Controllers'
// ], function () {
//     // Auth Routes
//     Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
//     Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

//     // Protected Routes
//     Route::group(['middleware' => ['auth.admin']], function () {
//         // Dashboard
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//         // User Management Routes
//         Route::prefix('users')->group(function () {
//             Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
//             Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
//             Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
//             Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
//             Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
//             Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
//             Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
            
//             // Avatar Routes
//             Route::get('/{id}/avatar', [UserAvatarController::class, 'showUploadForm'])->name('admin.users.avatar.form');
//             Route::post('/{id}/avatar', [UserAvatarController::class, 'upload'])->name('admin.users.avatar.upload');
//             Route::delete('/{id}/avatar', [UserAvatarController::class, 'delete'])->name('admin.users.avatar.delete');

//         });

//         // Blog Management Routes
//         Route::prefix('blogs')->group(function () {
//             Route::get('/', [BlogController::class, 'index'])->name('admin.blogs.index');
//             Route::get('/create', [BlogController::class, 'create'])->name('admin.blogs.create');
//             Route::post('/', [BlogController::class, 'store'])->name('admin.blogs.store');
//             Route::get('/{id}', [BlogController::class, 'show'])->name('admin.blogs.show');
//             Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
//             Route::put('/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
//             Route::delete('/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
            
//             // Status management routes
//             Route::patch('/{id}/publish', [BlogController::class, 'publish'])->name('admin.blogs.publish');
//             Route::patch('/{id}/archive', [BlogController::class, 'archive'])->name('admin.blogs.archive');
//         });
//     });
// });

