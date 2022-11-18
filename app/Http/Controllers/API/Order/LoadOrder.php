<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class LoadOrder extends Controller
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
        $user = Auth::user()->id;

        $ordersProducts = $orders->orderProducts($data['orderId']);

        $orderItem = OrderResource::collection($ordersProducts)->first();

        return compact('orderItem');
    }
}
