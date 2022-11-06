<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderProductsResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\Providers\Auth as ProvidersAuth;
use Illuminate\Support\Str;

class IndexOrder extends Controller
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

    public function __invoke(StoreOrderRequest $request, Order $orders)
    {
        $data = $request->validated();
        $user = Auth::user()->id;
        // dd($user);
        $token = Str::random(40);

        $order = Order::firstOrCreate(
            [
                'user_id' => $user,
                'status' => 0,
                'remember_token' => $token,
            ],
        );
        // dd($order);
        // dd(Order::where('user_id', $user)->get());
        if (isset($data)) {
            foreach ($data as $value) {
                foreach ($value as $val) {
                    // dd($val);
                    OrderProducts::firstOrCreate([
                        'order_id' => $order->id,
                        'product_id' => $val['id'],
                        'product_count' => $val['cnt'],
                        'remember_token' => $token,
                    ]);
                }
            }
        }
        dd($orders->products());
        dd($orders->products()->where('order_products')->where('user_id', 1)->get());
        // dd(Order::where('products', 1)->get());
        $orderProduct = OrderProducts::where('remember_token', $token)->get();
        // dd($orderProduct);
        $order = Order::where('remember_token', $token)->get();
        // $resourse = OrderResource::collection($orderct);
        $reources = OrderProductsResource::collection($orderProduct);
        // dd($reources);
        // dd(OrderProducts::all(), Order::all());
        return $reources;
        // return compact('reources');
    }
}