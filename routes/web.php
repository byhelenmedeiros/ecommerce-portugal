<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Shop/Home');
});

Route::get('/', [HomeController::class, 'index']);



Route::get('/search', function () {
    return Inertia::render('Shop/Search');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


Route::middleware('auth')->group(function () {
    // Dados de conta (nome/email/senha)
    Route::get('/conta', [ProfileController::class, 'edit'])->name('account.edit');
    Route::patch('/conta', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/conta', [ProfileController::class, 'destroy'])->name('account.destroy');

    // Dados do perfil complementar (morada, telefone, etc.)
    Route::get('/perfil', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [CustomerProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/modules/admin.php';
require __DIR__.'/modules/shop.php';
require __DIR__.'/modules/product.php';
require __DIR__.'/modules/order.php';
require __DIR__.'/modules/import.php';
//require __DIR__.'/modules/wishlist.php';
require __DIR__.'/modules/account.php';
