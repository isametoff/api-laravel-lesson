<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Resources\Cart\IndexCartResource;
use Illuminate\Support\Str;
use App\Models\Cart;


class IndexCart extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        // dd(isset($data['token']));
        $token = isset($data['token']) && mb_strlen($data['token']) > 39 ? $data['token'] : $data['token'] = Str::random(40);
        // dd($token);
        $product = Cart::create(
            [
                'remember_token' => $token
                ]
            );
            dd($product);
        $token = mb_strlen($oldToken) > 39 ? $oldToken : $data['token'] = Str::random(40);
        foreach (Cart::all() as $key => $value) {
            // dd($value['remember_token'] === $token);
            $cart = $value['remember_token'] === $token ? $value : Cart::create(['remember_token', $token]);
        }
        // if (dd($oldToken !== $carts[0]['remember_token'] && mb_strlen($carts) < 39)) {
        //     # code...
        // }
        // dd($cart);
        $cartJson = IndexCartResource::make($cart);
        // dd($cartJson);

        $needUpdate = true;

        return compact('cartJson', 'token', 'needUpdate');
    }
}
