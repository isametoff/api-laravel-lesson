<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\LoadRequest;
use App\Http\Resources\Cart\IndexCartResource;
use App\Models\Cart;
use Illuminate\Support\Str;

class IndexCart extends Controller
{
    
    public function __invoke(LoadRequest $request)
    {
        $data = $request->validated();
        $isData = isset($data['oldToken']) && Cart::where('remember_token', $data['oldToken'])->exists(); //bool
        $token = $isData && mb_strlen($data['oldToken']) === 40 ? $data['oldToken'] : Str::random(40);
        $cart = $isData ? Cart::where('remember_token', $token)->get() : [];
        $singleCart = Cart::where('remember_token', $token)->get();
        $cart = IndexCartResource::collection($singleCart);
        $needUpdate = isset($data['oldToken']) && $token == $data['oldToken'] ?  false : true;

        return compact('cart', 'token', 'needUpdate');
    }
}
