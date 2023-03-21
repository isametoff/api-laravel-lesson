<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProducts;
use App\Models\Products;

class Delete
{
    public static function index(int $userId, int $orderId): bool
    {
        $order = Order::where('user_id', $userId)->where('id', $orderId);
        $unfinished = $order->whereIn('status', [0, 1])->exists();
        if ($unfinished === true) {
            Delete::returnReservedProduct($userId, $orderId);
        }
        Order::where('user_id', $userId)->where('id', $orderId)->delete();
        OrderProducts::where('order_id', $orderId)->delete();
        $message = $order->doesntExist();
        return $message;
    }
    public static function returnReservedProduct(int $orderId)
    {
        $ordersUser = Order::where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        foreach ($orderProducts->products as $product) {
            Products::withTrashed()
                ->where('id', $product->id)
                ->restore();
        }
    }
}