<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class LoadAll
{
    public function __invoke(): object|bool
    {
        if (Order::where('user_id', Auth::user()->id)->exists()) {
            $ordersUser = Order::where('user_id', Auth::user()->id)->where('status', '!=', Status::ADDED);
            $ordersUserProducts = $ordersUser->with('products')->get();
            return OrderResource::collection($ordersUserProducts);
        } else {
            return false;
        }
    }
}