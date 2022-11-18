<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;
use App\Jobs\OrderAfterCreateJob;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RepeatOrder extends Controller
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
        $userId = Auth::user()->id;
        $orderId = $data['orderId'];

        $orderExample = $orders->orderProducts($orderId)->first();

        $orderRepeat = $orderExample->replicate([
            'created_at',
            'updated_at'
        ])->fill([
            'status' => Status::WAITING,
            'id' => $orders->id
        ]);
        $orderRepeat->save();
        $orderIdRepeat = $orderRepeat->id;

        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        foreach ($orderExample->products as $val) {
            $productRest = productsValue($products, $val->pivot->products_id, 'rest');
            $cnt = $productRest >= $val->pivot->product_count ? $val->pivot->product_count : $productRest;
            $orderProducts->firstOrCreate([
                'order_id' => $orderRepeat->id,
                'products_id' => $val->pivot->products_id,
                'product_count' => $cnt,
            ]);
            $products->where('id', $val->pivot->products_id)
                ->update([
                    'rest' => $productRest - $cnt,
                ]);
        }

        OrderAfterCreateJob::dispatch(compact('orderIdRepeat', 'userId'))->delay(now()->addSeconds(0));


        return compact('orderIdRepeat');
    }
}