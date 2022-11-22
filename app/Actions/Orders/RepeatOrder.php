<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Jobs\OrderAfterCreateJob;
use Illuminate\Support\Facades\Auth;
use App\Contracts\OrdersContract;
use App\Models\OrderProducts;
use App\Models\Products;
use App\Models\Order;

class RepeatOrder implements OrdersContract
{
    public function __invoke(array $data): int
    {
        $userId = Auth::user()->id;
        $dataOrderId = $data['orderId'];

        $orderExample = Order::orderProducts($dataOrderId)->first();

        $orderRepeat = $orderExample->replicate([
            'created_at',
            'updated_at'
        ])->fill([
            'status' => Status::WAITING,
        ]);
        $orderRepeat->save();
        $orderId = $orderRepeat->id;
        // return $orderId;



        foreach ($orderExample->products as $val) {
            $productRest = Order::productsValue(Products::all(), $val->pivot->products_id, 'rest');
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
