<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class AddToCart extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $isData = Cart::where('remember_token', $data['oldToken'])->exists(); //bool
        Cart::updateOrInsert(
            ['product_id' => $data['id'], 'remember_token' => $data['oldToken']],
            ['cnt' => 1]
        );

        $addToData = Cart::where('remember_token', $data['oldToken'])
            ->where('product_id', $data['id'])
            ->exists(); //bool


        return compact('addToData');
    }
}
