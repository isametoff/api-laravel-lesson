<?php

use App\Http\Controllers\API\Cart\AddToCart;
use App\Http\Controllers\API\Cart\IndexCart;
use App\Http\Controllers\API\Cart\RemoveCartProduct;
use App\Http\Controllers\API\Cart\SetCountProductCart;
use App\Http\Controllers\API\Order\AddingOrder;
use App\Http\Controllers\API\Order\CancelOrder;
use App\Http\Controllers\API\Order\DeleteOrder;
use App\Http\Controllers\API\Order\LoadAllOrders;
use App\Http\Controllers\API\Order\LoadOrder;
use App\Http\Controllers\API\Order\RepeatOrder;
use App\Http\Controllers\API\Order\StoreOrder;
use App\Http\Controllers\API\Order\TransactionOrder;
use App\Http\Controllers\API\User\RegistrationController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\IndexProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/cart', IndexCart::class);
Route::post('/cart/add', AddToCart::class);
Route::post('/cart/remove', RemoveCartProduct::class);
Route::post('/cart/count', SetCountProductCart::class);
Route::get('/products', IndexProduct::class);

Auth::routes();
Auth::routes(['verify' => true]);
Route::post('/registration', [RegistrationController::class, 'create']);
Route::get('/verifyemail/{token}', [RegistrationController::class, 'verify']);
Route::get('/repeatverifyemail/{token}', [RegistrationController::class, 'repeatVerify']);

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware('auth:api');
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::post('order', StoreOrder::class);
    Route::post('transaction', TransactionOrder::class);
    Route::post('order/load', LoadOrder::class);
    Route::post('order/all-load', LoadAllOrders::class);
    Route::post('order/delete', DeleteOrder::class);
    Route::post('order/repeat', RepeatOrder::class);
    Route::post('order/adding', AddingOrder::class);
    Route::post('order/cancel', CancelOrder::class);
});
