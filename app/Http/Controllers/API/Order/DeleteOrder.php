<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class DeleteOrder extends Controller
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

    public function __invoke(LoadOrderIdRequest $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request->validated();
        $userId = Auth::user()->id;

        $message = $orders->orderDelete($userId, $data['orderId']);

        return compact('message');
    }
}