<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDoorsController;
use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\Admin\AdminPermissionsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AdminZonesController;
use App\Http\Controllers\Device\AccessController;
use App\Http\Controllers\Public\RegisterController;
use App\Http\Controllers\Public\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Registration
    Route::get('/register/meta', [RegisterController::class, 'meta']);
    Route::post('/register', [RegisterController::class, 'register']);

    // Wallet passes
    Route::get('/wallet/apple/{userUuid}', [WalletController::class, 'apple']);
    Route::get('/wallet/samsung/{userUuid}', [WalletController::class, 'samsung']);
});

// Device routes (NFC readers)
Route::prefix('v1/access')->group(function () {
    Route::post('/validate', [AccessController::class, 'validate']);
});

// Admin API routes
Route::prefix('v1/admin')->group(function () {
    // Auth
    Route::post('/login', [AdminAuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Users
        Route::get('/users', [AdminUsersController::class, 'index']);
        Route::get('/users/{uuid}', [AdminUsersController::class, 'show']);
        Route::put('/users/{uuid}/status', [AdminUsersController::class, 'updateStatus']);

        // Wallet cards
        Route::get('/cards', [AdminWalletController::class, 'index']);
        Route::post('/cards/{id}/revoke', [AdminWalletController::class, 'revoke']);
        Route::post('/cards/{id}/reissue', [AdminWalletController::class, 'reissue']);

        // Zones
        Route::get('/zones', [AdminZonesController::class, 'index']);
        Route::post('/zones', [AdminZonesController::class, 'store']);
        Route::put('/zones/{id}', [AdminZonesController::class, 'update']);
        Route::delete('/zones/{id}', [AdminZonesController::class, 'destroy']);

        // Doors
        Route::get('/doors', [AdminDoorsController::class, 'index']);
        Route::post('/doors', [AdminDoorsController::class, 'store']);
        Route::put('/doors/{id}', [AdminDoorsController::class, 'update']);
        Route::delete('/doors/{id}', [AdminDoorsController::class, 'destroy']);

        // Permissions
        Route::get('/permissions', [AdminPermissionsController::class, 'index']);
        Route::post('/permissions', [AdminPermissionsController::class, 'store']);
        Route::put('/permissions/{id}', [AdminPermissionsController::class, 'update']);
        Route::delete('/permissions/{id}', [AdminPermissionsController::class, 'destroy']);

        // Logs
        Route::get('/logs', [AdminLogsController::class, 'index']);
    });
});
