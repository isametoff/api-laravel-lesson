<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\RemoveRequest;
use Illuminate\Support\Facades\DB;

class RemoveCartProduct extends Controller
{
    public function __invoke(RemoveRequest $request)
    {
        $data = $request->validated();

        DB::table('carts')
            ->where('remember_token', $data['oldToken'])
            ->where('products_id', $data['id'])
            ->delete();

        $removeData = DB::table('carts')
            ->where('remember_token', $data['oldToken'])
            ->where('products_id', $data['id'])
            ->doesntExist();

        return compact('removeData');
    }
}
