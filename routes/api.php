<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->name('auth.')->controller(AuthenticationController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');

Route::prefix('statistics')->middleware('auth:sanctum')->name('statistics.')->controller(StatisticsController::class)->group(function () {
    Route::get('overview', 'overview')->name('overview');
    Route::get('products', 'products')->name('products');
    Route::get('stock', 'stock')->name('stock');
    Route::get('pricing', 'pricing')->name('pricing');
});
