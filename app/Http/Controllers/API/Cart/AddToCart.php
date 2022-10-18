<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Resources\Cart\IndexCartResource;
use Illuminate\Support\Str;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class AddToCart extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        foreach (Cart::all() as $key => $value) {
            if ($value['remember_token'] === $data['oldToken']) {
                DB::table('carts')
                    ->where('remember_token', '=', $data['oldToken'])
                    ->update([
                        'product_id' => $data['id'],
                        'cnt' => 1,
                    ]);
                $cart = $data['id'];
            }
        };

        return compact('cart');
    }
}