<?php

use App\Http\Controllers\api\V1\ProductRatingController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// product
Route::apiResource('products', ProductController::class);

//product-rating
Route::prefix('v1')->group(function () {
    Route::get('products-rating/{product_id}', [ProductRatingController::class, 'index'])->name('products-rating.index');
    Route::get('products-rating/{product_id}/{product_attribute_id}', [ProductRatingController::class, 'show'])->name('products-rating.show');
    Route::post('products-rating', [ProductRatingController::class, 'store'])->name('products-rating.store');
    Route::patch('products-rating', [ProductRatingController::class, 'update'])->name('products-rating.update');
    Route::delete('products-rating/{product_rating_id}', [ProductRatingController::class, 'destroy'])->name('products-rating.destroy');
});


// fallback route
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
