<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderRequest;
use App\Http\Resources\Order\OrderProductsResource;
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
        $orderItems = [];
        $totalPrice = 0;
        $isToken = isset($data['tokenPay']) && $data['tokenPay'] !== false && mb_strlen($data['tokenPay']) === 40;
        $isValidTransaction = $orders->where('remember_token', $data['tokenPay'])->exists()
            && $orders->where('user_id', $user)->exists();
        $tokenPay = $isValidTransaction && $isToken ? $data['tokenPay'] : null;
        // return compact('tokenPay', 'isValidTransaction', 'isToken');

        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        // dd($isValidTransaction);
        // $orderCreate = $orders->where('remember_token', $tokenPay)->pluck('created_at');
        // $Minutesdiff = $orderCreate[0]->diffInMinutes(Carbon::now()) < 21;

        if ($isValidTransaction) {

            $orderProductsId = $orderProducts->where('remember_token', $tokenPay)->get();
            $orderProducts = $orders->where('remember_token', $tokenPay)->get();
            $orderPr = [$orderProducts, $orderProductsId];

            foreach ($orderProductsId as $value) {
                $price = $value['product_count'] * $products->where('id', $value['product_id'])->value('price');
                $totalPrice += $price;
            }

            $orderItems = OrderProductsResource::collection($orderProductsId);
            dd($orderPr);
        }


        return compact('orderItems', 'tokenPay', 'totalPrice');
    }
}