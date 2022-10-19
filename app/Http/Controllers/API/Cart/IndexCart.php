<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Resources\Cart\IndexCartResource;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IndexCart extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $token = isset($data['oldToken']) && mb_strlen($data['oldToken']) === 40 ? $data['oldToken'] : Str::random(40);
        $isData = Cart::where('remember_token', $data['oldToken'])->exists(); //bool
        $cart = $isData ? Cart::where('remember_token', $token)->get() : [];
        $singleCart = Cart::where('remember_token', $token)->get();
        $cart = IndexCartResource::collection($singleCart);
        $needUpdate = isset($data['oldToken']) && $token == $data['oldToken'] ?  false : true;

        return compact('cart', 'token', 'needUpdate');
    }
}
