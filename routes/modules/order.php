<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route; 


Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
 
Route::put('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

});
