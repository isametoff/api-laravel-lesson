<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderProductsResource;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionOrder extends Controller
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

    public function __invoke(StoreOrderRequest $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request->validated();
        $user = Auth::user()->id;
        $tokenPay = Str::random(40);

        $orderTime = $orders->where('remember_token', $data['tokenPay'])->pluck('created_at');
        dd($orderTime[0]);
        $Minutesdiff = $orderTime[0]->diffInMinutes(Carbon::now());
        dd($Minutesdiff);
        $isValidTransaction =
            $orders->where('remember_token', $data['tokenPay'])->exists();
        dd($isValidTransaction);

        $order = $orders->firstOrCreate(
            [
                'user_id' => $user,
                'status' => 0,
                'remember_token' => $tokenPay,
            ],
        );

        if (isset($data)) {
            foreach ($data as $value) {
                foreach ($value as $val) {
                    $orderProducts->firstOrCreate([
                        'order_id' => $order->id,
                        'product_id' => $val['id'],
                        'product_count' => $val['cnt'],
                        'remember_token' => $tokenPay,
                    ]);
                }
            }
        }
        $orderProductsId = $orderProducts->where('remember_token', $tokenPay)->get();
        $orderProducts = $orderProducts->where('remember_token', $tokenPay)->pluck('product_id');
        $totalPrice = 0;

        foreach ($orderProducts as $key => $value) {
            $totalPrice += Products::where('id', $value)->value('price');
        }

        $ordersItem = OrderProductsResource::collection($orderProductsId);

        return compact('ordersItem', 'tokenPay', 'totalPrice');
    }
}