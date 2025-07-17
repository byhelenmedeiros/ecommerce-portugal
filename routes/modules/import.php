<?php


use App\Http\Controllers\Admin\ProductImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
->group(function () {
    
    Route::get('products/import', [ProductImportController::class, 'showImportForm'])->name('products.import');
    Route::post('products/import-preview', [ProductImportController::class, 'preview'])->name(' products.import.preview');
    Route::post('products/import-confirm', [ProductImportController::class, 'importConfirm'])->name(' products.import.confirm');
});
