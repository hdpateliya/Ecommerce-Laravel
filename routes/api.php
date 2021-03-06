<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [\App\Http\Controllers\API\Auth\LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/userDetails', [\App\Http\Controllers\API\Auth\LoginController::class, 'userDetails']);
    Route::get('/logout', [\App\Http\Controllers\API\Auth\LoginController::class, 'logout']);

    Route::prefix('product')->as('product.')->group(function () {
        Route::get('/index', [ProductController::class, 'index']);
        Route::get('/details/{id}', [ProductController::class, 'details']);
        Route::get('/addToCart/{id}', [ProductController::class, 'addToCart']);
        Route::get('/checkInCart/{id}', [ProductController::class, 'CheckInCart']);
        Route::get('/ProductReview/{id}', [ProductController::class, 'ProductReview']);

    });
    Route::get('offers/{id}', [ProductController::class, 'offers']);
    Route::prefix('cart')->as('cart.')->group(function () {
        Route::get('/cartList', [ProductController::class, 'cartList']);
        Route::get('/cartQuantityAdd/{id}', [ProductController::class, 'cartQuantityAdd']);
        Route::get('/cartQuantityRemove/{id}', [ProductController::class, 'cartQuantityRemove']);
        Route::get('/removeFromCart/{id}', [ProductController::class, 'removeFromCart']);
    });
    Route::get('cartList', [ProductController::class, 'cartList']);

    Route::prefix('wishlist')->as('wishlist.')->group(function () {
        Route::get('/index', [WishListController::class, 'index']);
        Route::get('/addOrRemoveWishList/{id}', [WishListController::class, 'addOrRemoveWishList']);
    });
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\API\Auth\LoginController::class, 'userDetails']);
        Route::post('/profileUpdate', [\App\Http\Controllers\API\Auth\LoginController::class, 'userUpdate']);
    });


    Route::get('/brand', [ProductController::class, 'brand']);
    Route::get('/category', [ProductController::class, 'category']);

});

Route::get('/test', [ProductController::class, 'index']);
Route::get('/users', function () {
    return response()->json(\App\Models\User::all());
});
Route::get('/users/{id}', function ($id) {
    return response()->json(\App\Models\User::find($id));
});
