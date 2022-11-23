<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Delete;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;

class DeleteOrder extends Controller
{
    public function __invoke(LoadOrderIdRequest $request, Delete $deleteOrderAction)
    {
        $data = $request->validated();
        $message = $deleteOrderAction->index($data['orderId']);
        return compact('message');
    }
}