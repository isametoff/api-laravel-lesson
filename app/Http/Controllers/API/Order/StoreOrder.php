<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;

class StoreOrder extends Controller
{
    public function __invoke(StoreOrderRequest $request, Store $storeOrderAction)
    {
        $orderId = $storeOrderAction($request->validated());
        return compact('orderId');
    }
}