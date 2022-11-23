<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Repeat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;

class RepeatOrder extends Controller
{
    public function __invoke(LoadOrderIdRequest $request, Repeat $repeatOrderAction)
    {
        $data = $request->validated();
        $orderId = $repeatOrderAction($data['orderId']);
        return compact('orderId');
    }
}
