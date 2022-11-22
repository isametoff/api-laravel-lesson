<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\AddingOrder as AddingOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\AddingOrderRequest;

class AddingOrder extends Controller
{
    public function __invoke(AddingOrderRequest $request, AddingOrderAction $addingOrderAction)
    {
        $orderId = $addingOrderAction($request->validated());
        return compact('orderId');
    }
}