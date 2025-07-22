<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CustomerTagController;

// Rotas para TAGS
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tags', TagController::class); 
    Route::resource('customer-tags', CustomerTagController::class);
    
});
