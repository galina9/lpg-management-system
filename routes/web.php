<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\PaymentController;

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class)
        ->middleware('role:director,manager');

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class)
        ->middleware('role:director,manager');

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::resource('orders', OrderController::class)
        ->middleware('role:director,manager');

    Route::get('/orders/{order}/excel',
        [OrderController::class, 'exportExcel'])
        ->name('orders.excel');

    

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)
        ->middleware('role:director');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports',
        [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/sales',
        [ReportController::class, 'sales'])
        ->name('reports.sales')
        ->middleware('role:director,manager');

    Route::get('/reports/monthly',
        [ReportController::class, 'monthly'])
        ->name('reports.monthly');

    Route::get('/reports/monthly/pdf',
        [ReportController::class, 'monthlyPdf'])
        ->name('reports.monthly.pdf');
    

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    */

    Route::middleware('driver')->group(function () {

        Route::get('/driver',
            [DriverController::class, 'index'])
            ->name('driver.index');

        Route::patch('/driver/orders/{order}/start',
            [DriverController::class, 'start'])
            ->name('driver.orders.start');

        Route::patch('/driver/orders/{order}/complete',
            [DriverController::class, 'complete'])
            ->name('driver.orders.complete');

    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');



    /*
    |--------------------------------------------------------------------------
    | Stock
    |--------------------------------------------------------------------------
    */

    Route::get('/stock-history',[StockHistoryController::class, 'index'])
            ->middleware('role:director,manager')
            ->name('stock-history.index');

    Route::get('/stock-history/excel',
        [StockHistoryController::class, 'exportExcel'])
        ->name('stock-history.excel');

    Route::get('/stock-history/pdf',
        [StockHistoryController::class, 'exportPdf'])
        ->name('stock-history.pdf');



    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    Route::resource('payments', PaymentController::class)
    ->middleware('role:director,manager');


     /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */

    Route::get(
    '/orders/{order}/invoice',
    [OrderController::class, 'invoice']
)->name('orders.invoice');

});

require __DIR__.'/auth.php';