<?php

namespace App\Actions\Orders;

use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use Illuminate\Support\Facades\Auth;

class LoadAll
{
    public function __invoke($data)
    {
        if (Order::where('user_id', Auth::user()->id)->exists()) {
            $ordersUser = Order::where('user_id', Auth::user()->id);
            $ordersUserProducts = $ordersUser->with('products')
                ->orderBy($data['columnSort'], $data['bySort'])
                ->paginate($data['perPage'], ['*'], 'pageValue', $data['pageValue']);
            return OrderResource::collection($ordersUserProducts);
        } else {
            return false;
        }
    }
}