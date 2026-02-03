<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDoorsController;
use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\Admin\AdminPermissionsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AdminZonesController;
use App\Http\Controllers\Public\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public registration pages
Route::get('/register', function () {
    return view('public.register');
});

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/success/{userUuid}', function ($userUuid) {
    return view('public.success', ['userUuid' => $userUuid]);
});

// Admin routes
Route::prefix('admin')->group(function () {
    // Redirect /admin to /admin/login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Login page
    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login']);

    // Protected admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Users
        Route::get('/users', [AdminUsersController::class, 'index'])->name('admin.users');
        Route::get('/users/{uuid}', [AdminUsersController::class, 'show'])->name('admin.users.show');
        Route::post('/users/{uuid}/status', [AdminUsersController::class, 'updateStatus']);
        Route::delete('/users/{uuid}', [AdminUsersController::class, 'destroy']);

        // Cards
        Route::get('/cards', [AdminWalletController::class, 'index'])->name('admin.cards');
        Route::post('/cards/{id}/revoke', [AdminWalletController::class, 'revoke']);
        Route::post('/cards/{id}/reissue', [AdminWalletController::class, 'reissue']);

        // Zones
        Route::get('/zones', [AdminZonesController::class, 'index'])->name('admin.zones');
        Route::post('/zones', [AdminZonesController::class, 'store']);
        Route::put('/zones/{id}', [AdminZonesController::class, 'update']);
        Route::delete('/zones/{id}', [AdminZonesController::class, 'destroy']);

        // Doors
        Route::get('/doors', [AdminDoorsController::class, 'index'])->name('admin.doors');
        Route::post('/doors', [AdminDoorsController::class, 'store']);
        Route::put('/doors/{id}', [AdminDoorsController::class, 'update']);
        Route::delete('/doors/{id}', [AdminDoorsController::class, 'destroy']);

        // Permissions
        Route::get('/permissions', [AdminPermissionsController::class, 'index'])->name('admin.permissions');
        Route::post('/permissions', [AdminPermissionsController::class, 'store']);
        Route::put('/permissions/{id}', [AdminPermissionsController::class, 'update']);
        Route::delete('/permissions/{id}', [AdminPermissionsController::class, 'destroy']);

        // Logs
        Route::get('/logs', [AdminLogsController::class, 'index'])->name('admin.logs');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});

Route::get('/', function () {
    return redirect('/admin/login');
});
