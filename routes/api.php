<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('products', ProductController::class);
//Route::apiResource('products-rating', ProductRatingController::class);
Route::get('products-rating/{product_id}/{product_attribute_id}', [ProductRatingController::class, 'show']);
Route::get('products-rating/{product_id}', [ProductRatingController::class, 'index']);
Route::post('products-rating', [ProductRatingController::class, 'store']);
Route::patch('products-rating', [ProductRatingController::class, 'update']);
Route::delete('products-rating/{product_rating_id}', [ProductRatingController::class, 'destroy']);
