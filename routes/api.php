<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCommentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product/attributes', \App\Http\Controllers\ProductAttributeController::class);

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::get('/logined', 'logined');
});

//User Service
Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::delete('/{id}', 'destory');
    Route::get('/profile', 'profile');
});

Route::controller(ProductController::class)->prefix('product')->group(function () {
    Route::get('/', 'index');
    Route::get('/filter', 'filterProduct');
    Route::get('/search', 'SearchProduct');
    Route::get('/category/{id}', 'category');
    Route::get('/{id}', 'show');
});

Route::controller(OrderController::class)->prefix('order')->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::put('/user/{id}', 'update');
    Route::delete('/user/{id}', 'destroy');
    Route::get('/buyproduct/{hash}', 'buyproduct');
    Route::get('/myorders', 'myorders');
    Route::get('/{id}', 'show');
});

Route::controller(\App\Http\Controllers\CategoryController::class)->prefix('category')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::get('/products/{id}', 'category');
});

//Route::controller(ProductCommentsController::class)->prefix('comments')->group(function () {
//    Route::middleware('auth:sanctum')->group(function () {
//        Route::post('/add/{id}', 'store');
//        Route::post('/like/{id}', 'like');
//        Route::get('/likes/{id}', 'getlikes');
//    });
//    Route::get('/get/{id}', 'show');
//});

Route::controller(\App\Http\Controllers\FavoritController::class)->prefix('favorite')->group(function () {
    Route::get('/create', 'store');
    Route::get('/get', 'show');
    Route::delete('/clean_favorite', 'destroy');
});

Route::controller(\App\Http\Controllers\BasketController::class)->prefix('basket')->group(function () {
    Route::post('/clean_basket', 'clear_basket');
    Route::post('/create', 'store');
    Route::post('/get', 'show');
    Route::post('/decrement', 'decrement');
    Route::post('/increment', 'increment');
    Route::delete('/delete', 'destroy');
});

//Route::controller(\App\Http\Controllers\AddressController::class)->prefix('addresses')->middleware('auth:sanctum')->group(function () {
//    Route::post('/create', 'store');
//    Route::get('/get', 'show');
//    Route::get('/decrement', 'decrement');
//    Route::post('/delete', 'destroy');
//});

Route::controller(\App\Http\Controllers\SubCategoryController::class)->prefix('subcategory')->group(function () {
    Route::get('/', 'all');
    Route::get('/category/{id}', 'getCategory');
});

Route::get('/generate-guid', [\App\Http\Controllers\GuidController::class, 'generate']);

Route::middleware('auth:sanctum')
    ->prefix('admin')
    ->group(function () {
        Route::controller(\App\Http\Controllers\SubCategoryController::class)->prefix('subcategory')->group(function () {
            Route::get('/{id}', 'edit');
            Route::post('/create', 'store');
            Route::patch('/update/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
        Route::controller(\App\Http\Controllers\CategoryController::class)->prefix('category')->group(function () {
            Route::post('/create', 'store');
            Route::put('/update/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
        Route::controller(ProductController::class)->prefix('product')->group(function () {
            Route::post('/create', 'store');
            Route::patch('/update/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
        Route::controller(\App\Http\Controllers\BrandController::class)->prefix('brands')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'store');
            Route::post('/update/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
