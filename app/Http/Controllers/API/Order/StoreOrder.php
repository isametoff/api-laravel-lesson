<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Jobs\OrderAfterCreateJob;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

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
        $userId = Auth::user()->id;

        function productsValue($model, $column, $value)
        {
            // dd($value);
            return $model->where('id', $column)->value($value);
        }
        $order = $orders->firstOrCreate(
            [

                'id' => $orders->id,
                'user_id' => $userId,
                'status' => Status::WAITING,
            ],
        );
        $orderIdRepeat = $order->id;
        foreach ($data['order'] as $val) {
            $productRest = productsValue($products, $val['id'], 'rest');
            $cnt = $productRest >= $val['cnt'] ? $val['cnt'] : $productRest;
            $orderProducts->firstOrCreate([
                'order_id' => $order->id,
                'products_id' => $val['id'],
                'product_count' => $cnt,
            ]);
            $asd = $products->where('id', $val['id'])->get();

            $products->where('id', $val['id'])
                ->update([
                    'rest' => $productRest - $cnt,
                ]);
        }

        OrderAfterCreateJob::dispatch(compact('orderIdRepeat', 'userId'))->delay(now()->addSeconds(0)); // addMinutes or addSeconds


        return compact('orderIdRepeat');
    }
}