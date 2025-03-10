<?php

use App\Http\Controllers\Api\V1\BatchController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RefundController;
use App\Http\Controllers\Api\V1\StorageController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::get('/{id}/subcategories', [CategoryController::class, 'subcategories']);
    Route::get('/provider/{providerId}', [CategoryController::class, 'getByProvider']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/available', [ProductController::class, 'available']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/client/{clientId}', [OrderController::class, 'getByClient']);
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
    Route::post('/purchase', [BatchController::class, 'purchaseProduct']);
});

Route::prefix('storage')->group(function () {
    Route::get('/remaining', [StorageController::class, 'getRemainingQuantities']);
});
