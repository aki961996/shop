<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/shops', [AdminController::class, 'getShops']);
        Route::post('/shops', [AdminController::class, 'createShop']);
        Route::put('/shops/{shop}', [AdminController::class, 'updateShop']);
        Route::delete('/shops/{shop}', [AdminController::class, 'deleteShop']);
        
        Route::get('/products', [AdminController::class, 'getProducts']);
        Route::post('/products', [AdminController::class, 'createProduct']);
        Route::put('/products/{product}', [AdminController::class, 'updateProduct']);
        Route::delete('/products/{product}', [AdminController::class, 'deleteProduct']);
        
        Route::get('/stocks', [AdminController::class, 'getStocks']);
        Route::post('/stocks', [AdminController::class, 'createStock']);
        Route::put('/stocks/{stock}', [AdminController::class, 'updateStock']);
        Route::delete('/stocks/{stock}', [AdminController::class, 'deleteStock']);
        
        Route::get('/customers', [AdminController::class, 'getCustomers']);
    });

    // Shop Routes
    Route::middleware('shop')->prefix('shop')->group(function () {
        Route::get('/products', [ShopController::class, 'getProducts']);
        Route::post('/products', [ShopController::class, 'createProduct']);
        Route::put('/products/{product}', [ShopController::class, 'updateProduct']);
        Route::delete('/products/{product}', [ShopController::class, 'deleteProduct']);
        
        Route::get('/stocks', [ShopController::class, 'getStocks']);
        Route::post('/stocks', [ShopController::class, 'createStock']);
        Route::put('/stocks/{stock}', [ShopController::class, 'updateStock']);
    });

    // Customer Routes
    Route::middleware('customer')->prefix('customer')->group(function () {
        Route::get('/products', [CustomerController::class, 'getProducts']);
        Route::get('/cart', [CartController::class, 'getCart']);
        Route::post('/cart/add', [CartController::class, 'addToCart']);
        Route::put('/cart/update/{cartItem}', [CartController::class, 'updateCartItem']);
        Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart']);
        Route::delete('/cart/clear', [CartController::class, 'clearCart']);
    });
});

// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
