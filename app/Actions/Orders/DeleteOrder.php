<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProducts;

class DeleteOrder
{
    public function __invoke(array $data): bool
    {
        $userId = Auth::user()->id;
        $orderId = $data['orderId'];
        $ordersUserExist = Order::where('user_id', $userId)->where('id', $orderId)
            ->exists();
        Order::returnReservedProduct($userId, $orderId);
        Order::where('user_id', $userId)->where('id', $orderId)->delete();
        OrderProducts::where('order_id', $orderId)->delete();
        $message = Order::where('user_id', $userId)
            ->where('id', $orderId)->doesntExist();
        return $message;
    }
}