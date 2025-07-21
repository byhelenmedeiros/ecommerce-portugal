<?php
//rota para listar os clientes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
Route::get("/", [UserController::class,"index"])->name("admin.users.index");
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
