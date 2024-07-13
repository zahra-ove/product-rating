<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// product
Route::apiResource('products', ProductController::class);

//product-rating
Route::get('products-rating/{product_id}', [ProductRatingController::class, 'index'])->name('products-rating.index');
Route::get('products-rating/{product_id}/{product_attribute_id}', [ProductRatingController::class, 'show'])->name('products-rating.show');
Route::post('products-rating', [ProductRatingController::class, 'store'])->name('products-rating.store');
Route::patch('products-rating', [ProductRatingController::class, 'update'])->name('products-rating.update');
Route::delete('products-rating/{product_rating_id}', [ProductRatingController::class, 'destroy'])->name('products-rating.destroy');
