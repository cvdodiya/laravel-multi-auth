<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES — no auth needed
|--------------------------------------------------------------------------
*/

// Home / shop
Route::get('/', [CustomerProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| CUSTOMER AUTH ROUTES — redirect if already logged in
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register',  [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/login',     [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [CustomerAuthController::class, 'login']);
});

Route::post('/logout', [CustomerAuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| CUSTOMER PROTECTED ROUTES — must be logged in as a customer
| middleware('auth') = middleware('auth:web') — same thing
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/cart',              [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',         [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{product}',  [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout',    [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| ADMIN PUBLIC ROUTES — login page (guest:admin redirects logged-in admins)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN PROTECTED ROUTES — must be logged in via the 'admin' guard
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        // Full product CRUD — generates 7 named routes:
        //   admin.products.index, .create, .store, .show, .edit, .update, .destroy
        Route::resource('products', AdminProductController::class);

        // Extra: manual stock adjustment
        Route::post('/products/{product}/stock', [AdminProductController::class, 'adjustStock'])
            ->name('products.stock');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
