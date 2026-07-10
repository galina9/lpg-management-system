<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('products', ProductController::class)
        ->middleware('role:director,manager');

    Route::resource('customers', CustomerController::class)
        ->middleware('role:director,manager');

    Route::resource('orders', OrderController::class)
        ->middleware('role:director,manager');

    Route::resource('users', UserController::class)
        ->middleware('role:director');

    Route::get('/reports/sales', [ReportController::class, 'sales'])
        ->name('reports.sales')
        ->middleware('role:director,manager');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';