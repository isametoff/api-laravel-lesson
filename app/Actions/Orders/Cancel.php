<?php

namespace App\Actions\Orders;

use App\Enums\Order\Status;
use Illuminate\Support\Facades\DB;

class Cancel
{
    public function __invoke(int $userId, int $orderId): bool
    {
        $order = DB::table('orders')
            ->where('user_id', $userId)
            ->where('id', $orderId);
        $order->update([
            'status' => Status::CANCELED
        ]);
        Delete::returnReservedProduct($userId, $orderId);
        $ordersIsCancelled = $order
            ->where('status', Status::CANCELED)
            ->exists();

        return $ordersIsCancelled;
    }
}