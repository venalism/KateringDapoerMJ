<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// routes/web.php


Route::resource('menus', MenuController::class)->only(['index', 'show']);
Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');



Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::get('/', [MenuController::class, 'index']);

Route::get('/navbar', function () {
    return view('navbar');
});

Route::get('/beranda', function () {
    return view('beranda');
});




