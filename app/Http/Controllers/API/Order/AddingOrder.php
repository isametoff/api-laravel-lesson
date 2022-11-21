<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\AddingOrderRequest;
use App\Models\Order;

class AddingOrder extends Controller
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

    public function __invoke(AddingOrderRequest $request)
    {
        $data = $request->validated();
        $orderId = Order::addingOrder($data);
        return compact('orderId');
    }
}