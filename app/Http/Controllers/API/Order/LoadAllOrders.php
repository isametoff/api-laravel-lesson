<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\LoadAll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoadAllOrders extends Controller
{
    public function __invoke(Request $request, LoadAll $loadAllOrders)
    {
        $data = $request;
        $orderItems = $loadAllOrders();

        return compact('orderItems');
    }
}