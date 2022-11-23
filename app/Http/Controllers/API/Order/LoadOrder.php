<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\LoadLast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\NullOrderIdRequest;

class LoadOrder extends Controller
{
    public function __invoke(NullOrderIdRequest $request, LoadLast $loadOrder)
    {
        $data = $request->validated();
        $orderItem = $loadOrder();

        return compact('orderItem');
    }
}