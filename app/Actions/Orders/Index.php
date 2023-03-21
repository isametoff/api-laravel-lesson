<?php

namespace App\Actions\Orders;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderProducts;

class Index
{
    
    public static function isOrder()
    {
        return Order::where('user_id', Auth::user()->id)->where('status', 0)->exists();
    }

    public static function orderProducts(int $orderId): object
    {
        $user = Auth::user()->id;
        if (Order::where('user_id', $user)->exists()) {
            $ordersUser = Order::where('user_id', $user)->where('id', $orderId);
            $ordersProducts = $ordersUser->with('products')->get();
            return $ordersProducts;
        } else {
            return null;
        }
    }
    public static  function totalPrice($userId)
    {
        $total = 0;
        $order = Order::where('user_id', Auth::user()->id)->where('id', $userId);
        $orderItem = $order->with('products')->first();
        foreach ($orderItem->products as $product) {
            $price = $product->pivot->product_count * $product->price;
            $total += $price;
        }
        return $total;
    }
    public static function productsValue($model, $column, $value)
    {
        return $model->where('id', $column)->value($value);
    }
    public static function orderReserve($userId, $orderId)
    {
        $isOrder = Order::where('user_id', $userId)->where('id', $orderId)->exists();
        $orderUser = Order::where('user_id', $userId)->where('id', $orderId);
        // $waiting = get_object_vars(Status::WAITING);
        // $added = get_object_vars(Status::ADDED);

        // if ($isOrder === true) {
        //     if ($orderUser->first()->status === $added['value']) {
        //         Delete::index($userId, $orderId);
        //     } elseif ($orderUser->first()->status === $waiting['value']) {
        //         OrderAfterCheckingJob::dispatch(compact('userId', 'orderId'))->delay(now()->addSeconds(0));
        //     }
        // }
    }
    public static function orderCanceled(int $userId, int $orderId)
    {
        $isOrder = Order::where('user_id', $userId)->where('id', $orderId)->exists();
        $orderUser = Order::where('user_id', $userId)->where('id', $orderId);

        if ($orderUser->first()->status === 0 && $isOrder === true) {
            Delete::index($userId, $orderId);
        }
    }
}
