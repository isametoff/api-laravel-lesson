<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\loadAll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loadAllOrders extends Controller
{
    public function __invoke(Request $request, loadAll $loadAllOrders)
    {
        $data = $request;
        $orderItems = $loadAllOrders();

        return compact('orderItems');
    }
}