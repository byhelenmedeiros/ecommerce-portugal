<?php

use App\Http\Controllers\Shop\WishlistController;
use Illuminate\Routing\Route;

Route::inertia('/wishlist', 'WishlistPage')->name('wishlist');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy']);
});
