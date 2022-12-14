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
        $orderId = Str::random(40);

        $orderTime = $orders->where('id', $data['orderId'])->pluck('created_at');
        dd($orderTime[0]);
        $Minutesdiff = $orderTime[0]->diffInMinutes(Carbon::now());
        dd($Minutesdiff);
        $isValidTransaction =
            $orders->where('id', $data['orderId'])->exists();
        dd($isValidTransaction);

        $order = $orders->firstOrCreate(
            [
                'user_id' => $user,
                'status' => 0,
                'id' => $orderId,
            ],
        );

        if (isset($data)) {
            foreach ($data as $value) {
                foreach ($value as $val) {
                    $orderProducts->firstOrCreate([
                        'order_id' => $order->id,
                        'products_id' => $val['id'],
                        'product_count' => $val['cnt'],
                        'id' => $orderId,
                    ]);
                }
            }
        }
        $orderProductsId = $orderProducts->where('id', $orderId)->get();
        $orderProducts = $orderProducts->where('id', $orderId)->pluck('products_id');
        $totalPrice = 0;

        foreach ($orderProducts as $key => $value) {
            $totalPrice += Products::where('id', $value)->value('price');
        }

        $ordersItem = OrderProductsResource::collection($orderProductsId);

        return compact('ordersItem', 'orderId', 'totalPrice');
    }
}