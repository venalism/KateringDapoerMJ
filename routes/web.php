<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuPhotoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;


Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/profile/address/edit', [ProfileController::class, 'editAddress'])->name('profile.address.edit');
Route::post('/profile/address/update', [ProfileController::class, 'updateAddress'])->name('profile.address.update');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/form', [CheckoutController::class, 'form'])->name('checkout.form');
Route::post('/checkout/payment', [CheckoutController::class, 'process'])->name('checkout.payment');


Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});


Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// =====================

// GUEST (BELUM LOGIN)
// =====================
Route::get('/', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');

// =====================
// LOGIN / LOGOUT
// =====================



Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// =====================
// USER AREA (LOGIN WAJIB)
// =====================
Route::middleware(['auth'])->group(function () {
    // Cart (Keranjang)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // (Opsional) Tambahkan route checkout dan profil di sini
    // Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    // Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});

// =====================
// ADMIN AREA
// =====================
// routes/web.php


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('/menu', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);

    // Kelola Foto Menu
    Route::post('menus/{menuId}/photos', [MenuPhotoController::class, 'store'])->name('menu-photos.store');
    Route::delete('menu-photos/{photo}', [MenuPhotoController::class, 'destroy'])->name('menu-photos.destroy');
});
