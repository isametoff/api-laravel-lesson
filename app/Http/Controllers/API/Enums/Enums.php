<?php

namespace App\Http\Controllers\API\Enums;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enums\EnumsRequest;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class Enums extends Controller
{
    public function __invoke(EnumsRequest $request)
    {
        $data = $request->validated();
        $products = Products::allProducts();
        isset($data['stateSelect']) && $data['stateSelect'] && $data['stateSelect'][0] != null ?
            $products = $products->whereIn('state', $data['stateSelect']) : '';
        $data = $products->select($data['column'])
            ->where('deleted_at', null)
            ->where($data['column'], "LIKE", "%{$data['search']}%")
            ->select($data['column'])
            ->take(40)
            ->get();
        return compact("data");
    }
}
