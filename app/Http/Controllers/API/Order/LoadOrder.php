<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderRequest;
use App\Http\Resources\Order\OrderProductsResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Carbon\Carbon;
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

    public function __invoke(LoadOrderRequest $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request->validated();
        $user = Auth::user()->id;

        $ordersUser = $orders->where('user_id', $user)->where('remember_token', $data['tokenPay']);
        $ordersProducts = $ordersUser->with('products')->get();

        $orderItem = OrderResource::collection($ordersProducts)->first();

        return compact('orderItem');
    }
}
