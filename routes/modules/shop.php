<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Shop\WishlistController as ShopWishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CheckoutController;
use Inertia\Inertia;

// Rotas de administração (apenas para admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('regions', AdminRegionController::class);
    Route::resource('orders', AdminOrderController::class);
});

// Rotas de cliente autenticado (usuário logado)
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/me/wishlist', [ShopWishlistController::class, 'index'])->name('wishlist.index');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rotas públicas (sem autenticação)
Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');

//shop routes
Route::get('/shop', [ProductController::class, 'index'])->name('shop.products.index');
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('shop.products.show');

 
Route::inertia('/cart', 'CartPage')->name('cart');
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', fn () => Inertia::render('CheckoutSuccessPage'))->name('checkout.success');
});
