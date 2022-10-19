<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\SetCountRequest;
use Illuminate\Support\Facades\DB;

class SetCountProductCart extends Controller
{
    public function __invoke(SetCountRequest $request)
    {
        $data = $request->validated();
        if ($data['cnt'] < 1) {
            DB::table('carts')
                ->where('product_id', $data['id'])
                ->where('remember_token', '=', $data['oldToken'])
                ->delete();
            $setData = DB::table('carts')
                ->where('product_id', $data['id'])
                ->where('remember_token', $data['oldToken'])
                ->where('cnt', $data['cnt'])
                ->doesntExist(); //bool
        } else {
            DB::table('carts')
                ->where('product_id', '=', $data['id'])
                ->where('product_id', '=', $data['id'])
                ->where('remember_token', '=', $data['oldToken'])
                ->update([
                    'product_id' => $data['id'],
                    'cnt' => $data['cnt'],
                ]);

            $setData = DB::table('carts')
                ->where('product_id', $data['id'])
                ->where('remember_token', $data['oldToken'])
                ->where('cnt', $data['cnt'])
                ->exists(); //bool
        }
        return compact('setData');
    }
}
