<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Jobs\OrderAfterCreateJob;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProducts;
use App\Models\Products;

class Adding
{
    public function __invoke(array $data): int
    {
        $userId = Auth::user()->id;
        $orders = Order::where('user_id', $userId)->where('status', Status::ADDED)->get();

        foreach ($orders as $order) {
            Delete::index($userId, $order->id);
        }

        $order = Order::create([
            'user_id' => $userId,
            'status' => Status::ADDED,
        ]);
        $orderId = $order->id;
        foreach ($data['order'] as $val) {
            $productRest = Index::productsValue(Products::all(), $val['id'], 'rest');
            $cnt = $productRest >= $val['cnt'] ? $val['cnt'] : $productRest;
            OrderProducts::firstOrCreate([
                'order_id' => $order->id,
                'products_id' => $val['id'],
                'product_count' => $cnt,
            ]);
            Products::where('id', $val['id'])->update([
                'rest' => $productRest - $cnt,
            ]);
        }
        OrderAfterCreateJob::dispatch(compact('orderId', 'userId'))->delay(now()->addSeconds(30));

        return $orderId;
    }
}