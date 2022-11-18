<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddRequest;
use App\Models\Cart;

class AddToCart extends Controller
{
    public function __invoke(AddRequest $request)
    {
        $data = $request->validated();

        Cart::updateOrInsert(
            ['products_id' => $data['id'], 'remember_token' => $data['oldToken']],
            ['cnt' => 1]
        );

        $addToData = Cart::where('remember_token', $data['oldToken'])
            ->where('products_id', $data['id'])
            ->where('products_id', $data['id'])
            ->exists();

        return compact('addToData');
    }
}