<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;

Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class,'profile']);

    Route::post('/logout', [AuthController::class,'logout']);

    Route::get('/products', [ProductController::class, 'index']);

	Route::get('/products/{product}', [ProductController::class, 'show']);

	Route::get('/customers', [CustomerController::class, 'index']);
	Route::get('/customers/{customer}', [CustomerController::class, 'show']);

});