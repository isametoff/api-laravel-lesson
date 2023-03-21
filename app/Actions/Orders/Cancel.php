<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class Cancel
{
    public function one(int $userId, int $orderId): bool
    {
        $order = DB::table('orders')
            ->where('user_id', $userId)
            ->where('id', $orderId);
        $order->update([
            'status' => null
        ]);
        Delete::returnReservedProduct($userId, $orderId);
        $ordersIsCancelled = $order
            ->where('status', null)
            ->exists();

        return $ordersIsCancelled;
    }
    public static function all(int $userId)
    {
        $order = Order::where('user_id', $userId)
            ->where('status', 0);
        Delete::returnReservedProduct($order->value('id'));
        $order->update(['status' => 2]);
        $ordersIsCancelled = $order
            ->where('status', 2)
            ->exists();

        return $ordersIsCancelled;
    }
}