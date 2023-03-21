<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Resources\Products\IndexProductsResource;
use App\Models\OrderProducts;
use App\Models\Products;


class IndexProduct extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        return OrderProducts::all();
        // $products = Products::whereNotIn('column', [$value1, $value2])orderBy($data['columnSort'], $data['bySort'])
        //     ->paginate($data['perPage'], ['*'], 'pageValue', $data['pageValue']);

        // return IndexProductsResource::collection($products);
    }
}
