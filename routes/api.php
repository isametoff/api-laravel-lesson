<?php

use App\Http\Controllers\API\Cart\AddToCart;
use App\Http\Controllers\API\Cart\IndexCart;
use App\Http\Controllers\API\Cart\RemoveCartProduct;
use App\Http\Controllers\API\Cart\SetCountProductCart;
use App\Http\Controllers\API\Enums\Enums;
use App\Http\Controllers\API\Notification\Index as NotificationIndex;
use App\Http\Controllers\API\Order\CancelOrder;
use App\Http\Controllers\API\Order\DeleteOrder;
use App\Http\Controllers\API\Order\LoadAllOrders;
use App\Http\Controllers\API\Order\LoadOrder;
use App\Http\Controllers\API\Order\Package;
use App\Http\Controllers\API\Order\StoreOrder;
use App\Http\Controllers\API\Order\Viability;
use App\Http\Controllers\Api\Post\Create;
use App\Http\Controllers\Api\Post\Edit;
use App\Http\Controllers\API\Transaction\Index;
use App\Http\Controllers\API\Transaction\Load;
use App\Http\Controllers\API\User\RegistrationController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\User\AuthViability;
use App\Http\Controllers\API\User\ChangePassword;
use App\Http\Controllers\Export;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\IndexProduct;
use App\Http\Controllers\Api\Post\IndexPost;
use App\Http\Controllers\API\Statistics;
use App\Http\Controllers\PopularStates;
use App\Http\Controllers\TestProducts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::post('/products', IndexProduct::class);

Route::post('/broadcast', HelloController::class)->withoutMiddleware("throttle:api")
    ->middleware("throttle:400:1");
Broadcast::routes(['middleware' => 'auth:api', 'prefix' => 'auth']);

Auth::routes();
Auth::routes(['verify' => true]);
Route::post('/registration', [RegistrationController::class, 'create']);

Route::group(['middleware' => 'auth:api', 'prefix' => 'post'], function ($router) {
    Route::post('all-load', [IndexPost::class, 'index']);
    Route::post('create', [Create::class, 'store']);
    Route::post('update', [Edit::class, 'update']);
    Route::post('fix', [Edit::class, 'fix']);
    Route::post('delete', [Edit::class, 'delete']);
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', AuthViability::class)->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware('auth:api');
    Route::post('me', [AuthController::class, 'me']);
    Route::post('change-password', [ChangePassword::class, 'index']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'notification', "throttle:800:1", "throttle:30000:60"], function ($router) {
    Route::post('read', [NotificationIndex::class, 'read']);
    Route::post('delete', [NotificationIndex::class, 'delete']);
    Route::post('notification-messages', [NotificationIndex::class, 'notificationMessages']);
});

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::post('enums', Enums::class);
    Route::post('export', Export::class);
    Route::post('order', StoreOrder::class);
    Route::post('viability', Viability::class);
    Route::post('order/load', LoadOrder::class);
    Route::post('order/all-load', LoadAllOrders::class);
    Route::post('order/delete', DeleteOrder::class);
    Route::post('order/cancel-all', [CancelOrder::class, 'all']);
    Route::post('test/products', TestProducts::class);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'order'], function ($router) {
    Route::post('package-viability', [Package::class, 'viability']);
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'statistics'], function ($router) {
    Route::post('popular-states', [Statistics::class, 'popularStates']);
    Route::post('popular-states-user', [Statistics::class, 'popularStatesUser']);
    Route::post('popular-sity', [Statistics::class, 'popularSity']);
    Route::post('popular-sity-user', [Statistics::class, 'popularSityUser']);
    Route::post('graph', [Statistics::class, 'graph']);
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'transaction', "throttle:400:1", "throttle:6000:60"], function ($router) {
    Route::post('/', [Index::class, 'keyWallet']);
    Route::post('all', [Index::class, 'load']);
});
