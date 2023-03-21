<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Products as ActionsProducts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PackageRequest;
use App\Models\Products;

class Package extends Controller
{
    public function viability(PackageRequest $request)
    {
        $products = ActionsProducts::filter(Products::allProducts(), $request)->get();
        $productsCount = $products->count();
        $productsIds = $products->pluck('id')->take($request['plan'])->toArray();
        $thereProducts = $productsCount > $request['plan'];
        return compact('productsCount', 'thereProducts', 'productsIds');
    }
}
