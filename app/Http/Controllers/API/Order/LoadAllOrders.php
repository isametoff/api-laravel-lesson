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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadAllOrders extends Controller
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

    public function __invoke(Request $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request;

        // dd($isValidTransaction);
        // $orderCreate = $orders->where('remember_token', $tokenPay)->pluck('created_at');
        // $Minutesdiff = $orderCreate[0]->diffInMinutes(Carbon::now()) < 21;

        $ordersProducts = $orders->ordersProducts();
        $orderItems = OrderResource::collection($ordersProducts);

        return compact('orderItems');
    }
}