<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\POSController;
use App\Http\Controllers\Api\ReportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are called by the React frontend (Poachytr).
| All routes here return JSON, not HTML pages.
|
| Routes inside auth:sanctum middleware require a valid login token.
| The frontend must send the token in the Authorization header like:
|   Authorization: Bearer <token>
|
*/

// ── Public routes (no login required) ────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ── Protected routes (login required) ────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);         // Get logged-in user info

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::post('/inventory', [InventoryController::class, 'store']);
    Route::put('/inventory/{id}', [InventoryController::class, 'update']);
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy']);

    // Point of Sale
    Route::get('/pos/products', [POSController::class, 'products']);   // Get products for the POS grid
    Route::post('/pos/sale', [POSController::class, 'recordSale']);    // Record a completed sale

    // Reports
    Route::get('/reports', [ReportsController::class, 'index']);
});
