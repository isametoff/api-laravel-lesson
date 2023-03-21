<?php

namespace App\Actions\Orders;

use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Viability
{
    public function __invoke(array $ids)
    {
        $products = Products::whereIn('id', $ids)->get();
        $isProduct = count($products) < 1 ? false : true;
        $userId = Auth::user()->id;
        $amount = 0;
        $isProduct = false;
        foreach ($products as $val) {
            $is = $val->deleted_at != null;
            $is ? '' : $isProduct = true;
            $amount += $val->price;
        }
        $isBalance = User::where('id', $userId)->value('balance') >= $amount;

        return compact('isProduct', 'isBalance', 'amount');
    }
}
