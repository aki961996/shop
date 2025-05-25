<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Public Pages
Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/products', [WebController::class, 'products'])->name('products');

Route::get('/products/create', [WebController::class, 'create'])->name('products.create');
Route::post('/products', [WebController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [WebController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [WebController::class, 'update'])->name('products.update');

Route::get('/login', [WebController::class, 'loginForm'])->name('login');
Route::get('/register', [WebController::class, 'registerForm'])->name('register');

// Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [WebController::class, 'adminDashboard'])->name('admin.dashboard');
    // shop web api
    Route::get('/shops', [WebController::class, 'adminShops'])->name('admin.shops');
     Route::post('/shops', [WebController::class, 'storeShop'])->name('admin.shops.store');
    Route::put('/shops/{id}', [WebController::class, 'updateShop'])->name('admin.shops.update');

    // product
    Route::get('/products', [WebController::class, 'adminProducts'])->name('admin.products');
    Route::post('/products', [WebController::class, 'storeProduct'])->name('admin.products.store');
Route::put('/products/{id}', [WebController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/products/{id}', [WebController::class, 'destroy'])->name('admin.products.delete');
Route::get('/admin/products/{product}', [WebController::class, 'show'])->name('admin.product.show');


    Route::get('/stocks', [WebController::class, 'adminStocks'])->name('admin.stocks');
    Route::get('/customers', [WebController::class, 'adminCustomers'])->name('admin.customers');
});

// Shop Dashboard
Route::middleware(['auth', 'shop'])->prefix('shop')->group(function () {
    Route::get('/dashboard', [WebController::class, 'shopDashboard'])->name('shop.dashboard');
    Route::get('/products', [WebController::class, 'shopProducts'])->name('shop.products');
    Route::get('/stocks', [WebController::class, 'shopStocks'])->name('shop.stocks');
});

// Customer Dashboard
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [WebController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/cart', [WebController::class, 'customerCart'])->name('customer.cart');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
