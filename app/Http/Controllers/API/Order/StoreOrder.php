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
        // return $data;
        $orderItems = [];
        $totalPrice = 0;
        $isToken = isset($data['tokenPay']) && $data['tokenPay'] !== false && mb_strlen($data['tokenPay']) === 40;
        // dd("🚀 ~ file: StoreOrder.php ~ line 34 ~ isToken", $isToken);
        $isValidTransaction = $isToken ? $orders->where('remember_token', $data['tokenPay'])->exists() : false;
        $tokenPay = $isValidTransaction && $isToken ? $data['tokenPay'] : Str::random(40);
        // return compact('tokenPay', 'isValidTransaction', 'isToken');
        // dd("🚀 ~ file: StoreOrder.php ~ line 33 ~ ", $tokenPay);

        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        // if ($isValidTransaction === false) {
            // dd($isValidTransaction);
            // $orderCreate = $orders->where('remember_token', $tokenPay)->pluck('created_at');
            // $Minutesdiff = $orderCreate[0]->diffInMinutes(Carbon::now()) < 21;

            $order = $orders->firstOrCreate(
                [
                    'user_id' => $user,
                    'status' => 0,
                    'remember_token' => $tokenPay,
                ],
            );

            foreach ($data['order'] as $val) {
                $productRest = productsValue($products, $val['id'], 'rest');
                $cnt = $productRest >= $val['cnt'] ? $val['cnt'] : $productRest;
                // $orderProducts->firstOrCreate([
                //     'order_id' => $order->id,
                //     'product_id' => $val['id'],
                //     'product_count' => $cnt,
                //     'remember_token' => $tokenPay,
                // ]);
                $orderProducts->updateOrInsert([
                    'order_id' => $order->id,
                    'product_id' => $val['id'],
                    'remember_token' => $tokenPay,
                ], ['product_count' => $cnt,]);
            }
            $orderProductsId = $orderProducts->where('remember_token', $tokenPay)->get();
            $orderProducts = $orderProducts->where('remember_token', $tokenPay)->pluck('product_id');

            foreach ($orderProducts as $key => $value) {
                $totalPrice += $products->where('id', $value)->value('price');
            }

            $orderItems = OrderProductsResource::collection($orderProductsId);
        // }
        // else {
        //     $orderProductsId = $orderProducts->where('remember_token', $tokenPay)->get();
        //     $orderProducts = $orderProducts->where('remember_token', $tokenPay)->pluck('product_id');

        //     foreach ($orderProducts as $key => $value) {
        //         $totalPrice += $products->where('id', $value)->value('price');
        //     }

        //     $orderItems = OrderProductsResource::collection($orderProductsId);
        // }


        return compact('orderItems', 'tokenPay', 'totalPrice');
    }
}
