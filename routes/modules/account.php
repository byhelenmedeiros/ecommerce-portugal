<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\WishlistController;

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

    // Moradas gerais (admin ou lista do utilizador)
    Route::get('/morada', [AddressController::class, 'show'])->name('addresses');
    Route::get('/address', [AddressController::class, 'index'])->name('address');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::patch('/address/{address}', [AddressController::class, 'update'])->name('address.update');

// Mostrar a view com ambas moradas (fiscal + entrega)
Route::get('/address/account', [AddressController::class, 'show'])->name('address.account');
Route::patch('/account', [AccountController::class, 'update'])->name('account.update');



// Atualizar morada fiscal
Route::patch('/address/account/fiscal', [AddressController::class, 'updateFiscal'])->name('address.account.fiscal');
Route::delete('/address/account/fiscal', [AddressController::class, 'destroyFiscal'])->name('account.address.account.fiscal.destroy');

// Atualizar morada de entrega
Route::patch('/address/account/entrega', [AddressController::class, 'updateEntrega'])->name('address.account.entrega');
Route::delete('/address/account/entrega', [AddressController::class, 'destroyEntrega'])->name('account.address.account.entrega.destroy');


    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});
