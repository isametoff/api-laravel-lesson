<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\IndexProductsResource;
use App\Models\Products;


class IndexController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // return Products::all();
        // return dd('111');
        $products = Products::all();

        return IndexProductsResource::collection($products);
    }
}