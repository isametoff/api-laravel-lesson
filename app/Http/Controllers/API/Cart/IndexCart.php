<?php

namespace App\Http\Controllers\API\Cart;

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
        // dd(mb_strlen($data['oldToken']));
        $newToken = Str::random(40);
        isset($data['oldToken']) && mb_strlen($data['oldToken']) === 40 && Cart::all()->count() > 0 ? Cart::all() : Cart::create(
            [
                'cnt' => 0,
                'product_id' => 0,
                'remember_token' => $newToken,
            ]
        );
        $token = isset($data['oldToken']) && mb_strlen($data['oldToken']) === 40 ? $data['oldToken'] : $newToken;
        foreach (Cart::all() as $key => $value) {
            if ($value['remember_token'] == $token) {
                $cart = $value;
            }
        }
        $cart = isset($cart['id']) ? IndexCartResource::make($cart) : '';
        // dd($cart);

        // dd($token);
        $needUpdate = isset($data['oldToken']) && $token == $data['oldToken'] ?  true : false;
        // dd($needUpdate);

        return compact('cart', 'token', 'needUpdate');
    }
}