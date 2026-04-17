<?php

use App\Http\Controllers\PoachyController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/login', [PoachyController::class, 'login'])->name('poachy.login');
Route::get('/dashboard', [PoachyController::class, 'dashboard'])->name('poachy.dashboard');
Route::get('/pos', [PoachyController::class, 'pos'])->name('poachy.pos');
Route::get('/inventory', [PoachyController::class, 'inventory'])->name('poachy.inventory');
Route::get('/reports', [PoachyController::class, 'reports'])->name('poachy.reports');
Route::get('/expenses', [PoachyController::class, 'expenses'])->name('poachy.expenses');
Route::get('/ecommerce', [PoachyController::class, 'ecommerce'])->name('poachy.ecommerce');
Route::get('/customers', [PoachyController::class, 'customers'])->name('poachy.customers');
Route::get('/settings', [PoachyController::class, 'settings'])->name('poachy.settings');
