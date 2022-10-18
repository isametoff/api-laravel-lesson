<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\IndexProductsResource;
use App\Models\Products;


class IndexProduct extends Controller
{
    public function __invoke()
    {
        $products = IndexProductsResource::collection(Products::all());

        return $products;
    }
}
