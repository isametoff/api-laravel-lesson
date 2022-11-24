<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProducts;
use App\Models\Products;

class Delete
{
    public static function index(int $userId, int $orderId): bool
    {
        $ordersUserExist = Order::where('user_id', $userId)->where('id', $orderId)
            ->exists();
        Delete::returnReservedProduct($userId, $orderId);
        Order::where('user_id', $userId)->where('id', $orderId)->delete();
        OrderProducts::where('order_id', $orderId)->delete();
        $message = Order::where('user_id', $userId)
            ->where('id', $orderId)->doesntExist();
        return $message;
    }
    public static function returnReservedProduct(int $userId, int $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        // dd($userId, $orderId);
        foreach ($orderProducts->products as $product) {
            $rest = Products::where('id', $product->pivot->products_id)->value('rest');
            Products::where('id', $product->pivot->products_id)
                ->update([
                    'rest' => $rest + $product->pivot->product_count,
                ]);
        }
    }
}