<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuPhotoController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', [MenuController::class, 'index'])->name('menus.index');

Route::resource('menus', MenuController::class)->only(['index', 'show']);
Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function() {
        return redirect()->route('menu.index');
    });
    
    Route::resource('menu', AdminMenuController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);

    // Rute untuk Kelola Foto Menu
    Route::post('menus/{menuId}/photos', [MenuPhotoController::class, 'store'])->name('menu-photos.store');
    Route::delete('menu-photos/{photo}', [MenuPhotoController::class, 'destroy'])->name('menu-photos.destroy');
});