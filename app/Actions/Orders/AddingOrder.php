<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Jobs\OrderAfterCreateJob;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Contracts\OrdersContract;
use App\Models\OrderProducts;
use App\Models\Products;

class AddingOrder implements OrdersContract
{
    public function __invoke(array $data): int
    {
        $userId = Auth::user()->id;

        $order = Order::create([
            'user_id' => $userId,
            'status' => Status::ADDED,
        ]);
        $orderId = $order->id;
        foreach ($data['order'] as $val) {
            $productRest = Order::productsValue(Products::all(), $val['id'], 'rest');
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
        OrderAfterCreateJob::dispatch(compact('orderId', 'userId'))->delay(now()->addMinutes(5));
        
        return $orderId;
    }
}