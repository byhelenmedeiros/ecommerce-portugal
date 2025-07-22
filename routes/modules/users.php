<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerTagController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');  

       Route::post('/users/{user}/tags', [CustomerTagController::class, 'attach'])->name('users.tags.attach');
    Route::delete('/users/{user}/tags/{tag}', [CustomerTagController::class, 'detach'])->name('users.tags.detach');

});