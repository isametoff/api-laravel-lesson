<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use App\Jobs\OrderAfterCreateJob;
use Illuminate\Support\Facades\Auth;
use App\Contracts\OrdersContract;
use App\Models\Order;

class StoreOrder implements OrdersContract
{
    public function __invoke(array $data): int
    {
        $userId = Auth::user()->id;
        $orderId = $data['orderId'];

        Order::where('id', $orderId)->update([
            'status' => Status::WAITING,
        ]);
        OrderAfterCreateJob::dispatch(compact('orderId', 'userId'))->delay(now()->addMinutes(5));

        return $orderId;
    }
}