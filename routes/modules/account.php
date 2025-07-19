<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\WishlistController;

// Página inicial (exemplo de fallback ou teste local)
Route::get('/', fn () => Inertia::render('Account/Index'))->name('home');

// Grupo autenticado com prefixo "account"
Route::middleware(['auth'])->prefix('account')->name('account.')->group(function () {
    
    // Conta do usuário
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::patch('/', [AccountController::class, 'update'])->name('update');
    Route::delete('/', [AccountController::class, 'destroy'])->name('destroy');

    // Dados pessoais (edição inline)
    Route::get('/personal-data', [AccountController::class, 'personalData'])->name('personalData');
    Route::patch('/personal-data', [AccountController::class, 'updatePersonalData'])->name('personalData.update');

    // Pedidos
    Route::get('/orders', [ShopOrderController::class, 'index'])->name('orders');

// Morada
Route::get('/address', [AddressController::class, 'index'])->name('address');
Route::post('/address', [AddressController::class, 'store'])->name('address.store');
Route::patch('/address/{address}', [AddressController::class, 'update'])->name('address.update');
Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');


    // Wishlist
   Route::middleware(['auth'])->prefix('account')->name('account.')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});
});
