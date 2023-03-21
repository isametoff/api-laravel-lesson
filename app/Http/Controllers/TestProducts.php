<?php

namespace App\Http\Controllers;

use App\Actions\Products as ActionsProducts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\TestRequest;
use App\Http\Resources\Products\IndexProductsResource;
use App\Models\Products;

class TestProducts extends Controller
{
    public function __invoke(TestRequest $request, Products $products)
    {
        $data = $request->validated();

        $products = Products::allProducts()->orderBy($data['columnSort'], $data['bySort']);
        $products = ActionsProducts::filter($products, $data);

        $products = $products->paginate($data['perPage'], ['*'], 'pageValue', $data['pageValue']);
        return IndexProductsResource::collection($products);
    }
}
