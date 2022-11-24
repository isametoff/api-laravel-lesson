<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Jobs\OrderAfterCreateJob;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProducts;
use App\Models\Products;
use App\Models\Order;

class Repeat
{
    public function __invoke(int $orderId)
    {
        $userId = Auth::user()->id;
        $orders = Order::where('user_id', $userId)->where('status', Status::ADDED)->get();


        $orderExample = Index::orderProducts($orderId)->first();
        $orderRepeat = $orderExample->replicate([
            'created_at',
            'updated_at'
        ])->fill([
            'status' => Status::ADDED,
        ]);

        foreach ($orders as $order) {
            Delete::index($userId, $order->id);
        }

        $orderRepeat->save();
        $orderId = $orderRepeat->id;

        foreach ($orderExample->products as $val) {
            $productRest = Index::productsValue(Products::all(), $val->pivot->products_id, 'rest');
            $cnt = $productRest >= $val->pivot->product_count ? $val->pivot->product_count : $productRest;
            OrderProducts::firstOrCreate([
                'order_id' => $orderRepeat->id,
                'products_id' => $val->pivot->products_id,
                'product_count' => $cnt,
            ]);
            Products::where('id', $val->pivot->products_id)
                ->update([
                    'rest' => $productRest - $cnt,
                ]);
        }
        OrderAfterCreateJob::dispatch(compact('orderId', 'userId'))->delay(now()->addMinutes(5));

        return $orderId;
    }
}