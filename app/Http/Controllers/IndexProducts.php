<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\IndexProductsResource;
use App\Models\Products;


class IndexProducts extends Controller
{
    public function __invoke()
    {
        // return Products::all();
        // return dd('111');
        // $products = Products::all();


        // return (IndexProductsResource::collection($products));
        $products = Products::all();
        $produtsJson = IndexProductsResource::collection($products);

        return compact('products', 'produtsJson');
    }
}