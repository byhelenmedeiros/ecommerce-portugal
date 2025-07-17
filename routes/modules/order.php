<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route; 


Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::put('/{order}', [OrderController::class, 'update'])->name('update');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    // Se precisares de editar/criar mais tarde, adicionas aqui
});
