<?php

use App\Http\Controllers\Api\V1\BatchController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RefundController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
});

Route::prefix('refunds')->group(function () {
    Route::get('/', [RefundController::class, 'index']);
    Route::get('/{id}', [RefundController::class, 'show']);
    Route::post('/', [RefundController::class, 'store']);
});

Route::prefix('batches')->group(function () {
    Route::get('/profit', [BatchController::class, 'calculateProfit']);
});