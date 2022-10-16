<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\IndexCartResource;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Str;


class IndexCart extends Controller
{
    public function __invoke()
    {
        $token = Str::random(40);
        $cart = Cart::all();
        $cartJson = IndexCartResource::collection($cart);

        return dd($cartJson);
        // return compact('cartJson', 'token');
    }
}