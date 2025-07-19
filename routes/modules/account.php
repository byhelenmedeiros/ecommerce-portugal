<?php

//rota de conta do usuário
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/", function () {
    return Inertia::render("Account/Index");  
})->name("account.index");

Route::middleware(['auth'])->group(function () {
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::patch('/account', [\App\Http\Controllers\AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [\App\Http\Controllers\AccountController::class, 'destroy'])->name('account.destroy');
});