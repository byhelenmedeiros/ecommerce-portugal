<?php


use App\Http\Controllers\Admin\ProductImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('products/import', [ProductImportController::class, 'showImportForm'])->name('admin.products.import');
    Route::post('products/import-preview', [ProductImportController::class, 'preview'])->name('admin.products.import.preview');
    Route::post('products/import-confirm', [ProductImportController::class, 'importConfirm'])->name('admin.products.import.confirm');
});
