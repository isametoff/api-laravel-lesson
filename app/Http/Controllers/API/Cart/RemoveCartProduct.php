<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use Illuminate\Support\Facades\DB;

class RemoveCartProduct extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        DB::table('carts')
            ->where('remember_token', '=', $data['oldToken'])
            ->where('product_id', '=', $data['id'])
            ->delete();

        $removeData = DB::table('carts')
            ->where('remember_token', $data['oldToken'])
            ->doesntExist(); //bool

        return compact('removeData');
    }
}
