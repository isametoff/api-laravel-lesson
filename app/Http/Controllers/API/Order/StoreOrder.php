<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderProductsResource;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreOrder extends Controller
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
        $orderItems = [];
        $totalPrice = 0;
        $tokenPay = Str::random(40);

        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        $order = $orders->firstOrCreate(
            [
                'user_id' => $user,
                'status' => Status::ONGOING,
                'remember_token' => $tokenPay,
            ],
        );

        foreach ($data['order'] as $val) {
            $productRest = productsValue($products, $val['id'], 'rest');
            $cnt = $productRest >= $val['cnt'] ? $val['cnt'] : $productRest;
            $orderProducts->firstOrCreate([
                'order_id' => $order->id,
                'product_id' => $val['id'],
                'product_count' => $cnt,
                'remember_token' => $tokenPay,
            ]);
            // $orderProducts->updateOrInsert([
            //     'order_id' => $order->id,
            //     'product_id' => $val['id'],
            //     'remember_token' => $tokenPay,
            // ], ['product_count' => $cnt,]);
        }
        $orderProductsId = $orderProducts->where('remember_token', $tokenPay)->get();

        foreach ($orderProductsId as $value) {
            $price = $value['product_count'] * $products->where('id', $value['id'])->value('price');

            $totalPrice += $price;
        }

        $orderItems = OrderProductsResource::collection($orderProductsId);

        return compact('orderItems', 'tokenPay', 'totalPrice');
    }
}
