<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Cancel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;
use Illuminate\Support\Facades\Auth;

class CancelOrder extends Controller
{
    public function __invoke(LoadOrderIdRequest $request, Cancel $cancelOrderAction)
    {
        $data = $request->validated();
        $userId = Auth::user()->id;
        $orderId = $cancelOrderAction($userId, $data['orderId']);
        return compact('orderId');
    }
}