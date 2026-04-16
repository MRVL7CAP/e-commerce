<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{product:slug}', [HomeController::class, 'show'])
    ->name('products.show');


Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');
Route::post('/cart/store', [CartController::class, 'store'])
    ->name('cart.store');

Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout')
    ->middleware('auth');

Route::get('/checkout/success', [CheckoutController::class, 'success'])
    ->name('checkout.success')
    ->middleware('auth');

Route::get('/checkout.cancel', [CheckoutController::class, 'cancel'])
    ->name('checkout.cancel')
    ->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/invoice/{order}', [ProfileController::class, 'invoice'])->name('profile.invoice');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});


Route::prefix('admin')
    ->middleware(['auth', 'isadmin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');


        Route::resource('products', ProductController::class);
        Route::get('categories/products-count', [CategoryController::class, 'count']);
        Route::resource('categories', CategoryController::class);
    });
