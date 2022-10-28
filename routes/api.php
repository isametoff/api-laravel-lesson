<?php

use App\Http\Controllers\API\Cart\AddToCart;
use App\Http\Controllers\API\Cart\IndexCart;
use App\Http\Controllers\API\Cart\RemoveCartProduct;
use App\Http\Controllers\API\Cart\SetCountProductCart;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\User\RegistrationController;
use App\Http\Controllers\IndexProduct;
use Illuminate\Support\Facades\Route;

Route::post('/cart', IndexCart::class);
Route::post('/cart/add', AddToCart::class);
Route::post('/cart/remove', RemoveCartProduct::class);
Route::post('/cart/count', SetCountProductCart::class);
Route::get('/products', IndexProduct::class);
Route::post('/registration', RegistrationController::class);
Route::post('/auth', AuthController::class);
