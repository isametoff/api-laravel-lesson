<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Delete;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;
use Illuminate\Support\Facades\Auth;

class DeleteOrder extends Controller
{
    public function __invoke(LoadOrderIdRequest $request, Delete $deleteOrderAction)
    {
        $data = $request->validated();
        $userId = Auth::user()->id;
        $message = $deleteOrderAction->index($userId, $data['orderId']);
        return compact('message');
    }
}