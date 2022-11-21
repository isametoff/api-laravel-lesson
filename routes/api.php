<?php

use App\Http\Controllers\API\Cart\AddToCart;
use App\Http\Controllers\API\Cart\IndexCart;
use App\Http\Controllers\API\Cart\RemoveCartProduct;
use App\Http\Controllers\API\Cart\SetCountProductCart;
use App\Http\Controllers\API\Order\AddingOrder;
use App\Http\Controllers\API\Order\DeleteOrder;
use App\Http\Controllers\API\Order\LoadAllOrders;
use App\Http\Controllers\API\Order\LoadOrder;
use App\Http\Controllers\API\Order\RepeatOrder;
use App\Http\Controllers\API\Order\StoreOrder;
use App\Http\Controllers\API\Order\TransactionOrder;
use App\Http\Controllers\API\User\RegistrationController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\IndexProduct;
use Illuminate\Support\Facades\Route;

Route::post('/cart', IndexCart::class);
Route::post('/cart/add', AddToCart::class);
Route::post('/cart/remove', RemoveCartProduct::class);
Route::post('/cart/count', SetCountProductCart::class);
Route::get('/products', IndexProduct::class);
Route::post('/registration', RegistrationController::class);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('order', StoreOrder::class);
    Route::post('transaction', TransactionOrder::class);
    Route::post('order/load', LoadOrder::class);
    Route::post('order/all-load', LoadAllOrders::class);
    Route::post('order/delete', DeleteOrder::class);
    Route::post('order/repeat', RepeatOrder::class);
    Route::post('order/adding', AddingOrder::class);
});