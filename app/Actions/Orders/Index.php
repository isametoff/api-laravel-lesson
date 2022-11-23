<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Http\Resources\Order\OrderResource;
use App\Jobs\OrderAfterCheckingJob;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Products;

class Index
{
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
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);
        $added = get_object_vars(Status::ADDED);

        if ($ordersUser->first()->status === $added['value']) {
            Delete::deleteOrder($userId, $orderId);
        }
        if ($ordersUser->first()->status === $waiting['value']) {
            OrderAfterCheckingJob::dispatch(compact('orderId', 'userId'))->delay(now()->addSeconds(6));
        }
    }
    public static function orderCanceled(int $userId, int $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);
        $canceled = get_object_vars(Status::CANCELED);


        if ($ordersUser->first()->status === $waiting['value']) {
            Index::deleteOrder($userId, $orderId);
        } elseif ($ordersUser->first()->status === $canceled['value']) {
            foreach ($orderProducts->products as $product) {
                $rest = Products::where('id', $product->pivot->products_id)->value('rest');
                Products::where('id', $product->pivot->products_id)
                    ->update([
                        'rest' => $rest + $product->pivot->product_count,
                    ]);
            }
        }
    }
}
