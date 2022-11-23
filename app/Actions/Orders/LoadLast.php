<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class LoadLast
{
    public function __invoke(): object|bool
    {
        $user = Auth::user()->id;
        if (Order::where('user_id', $user)->exists()) {
            $ordersItems = Order::where('user_id', $user)->whereIn('status', [Status::WAITING, Status::ADDED]);
            $orderId = $ordersItems->orderByDesc('updated_at')->first()->id;
            $ordersUser = Order::where('user_id', $user)->where('id', $orderId);
            $ordersProducts = $ordersUser->with('products')->get();
            return OrderResource::collection($ordersProducts)->first();
        } else {
            return false;
        }
    }
}