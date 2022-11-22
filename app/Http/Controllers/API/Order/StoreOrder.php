<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\StoreOrder as StoreOrderAction;
use App\Contracts\OrdersContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;

class StoreOrder extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(StoreOrderRequest $request, StoreOrderAction $storeOrderAction)
    {
        $orderId = $storeOrderAction($request->validated());
        return compact('orderId');
    }
}