<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/comments', [\App\Http\Controllers\ProductCommentController::class, 'store'])->name('products.comments.store');
    Route::delete('/products/{product}/comments/{comment}', [\App\Http\Controllers\ProductCommentController::class, 'destroy'])->name('products.comments.destroy');
});

//aprovar o recusar comentários
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/comments/{comment}/approve', [\App\Http\Controllers\ProductCommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\ProductCommentController::class, 'destroy'])->name('comments.destroy');
});