<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadTokenPayRequest;
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

    public function __invoke(LoadTokenPayRequest $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request->validated();
        $userId = Auth::user()->id;
        $tokenPay = Str::random(40);
        $tokenExample = $data['tokenPay'];

        $orderExample = $orders->orderProducts($tokenExample)->first();

        $orderRepeat = $orderExample->replicate([
            'created_at',
            'updated_at'
        ])->fill([
            'status' => Status::WAITING,
            'remember_token' => $tokenPay
        ]);

        $orderRepeat->save();

        // return compact('orderRepeat');


        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        $asd = $orderExample->products;
        foreach ($asd as $val) {
            // return $val;
            $productRest = productsValue($products, $val->pivot->product_id, 'rest');
            $cnt = $productRest >= $val->pivot->product_count ? $val->pivot->product_count : $productRest;
            $orderProducts->firstOrCreate([
                'order_id' => $orderRepeat->id,
                'product_id' => $val->pivot->product_id,
                'product_count' => $cnt,
                'remember_token' => $tokenPay,
            ]);
            $products->where('id', $val->pivot->product_id)
                ->update([
                    'rest' => $productRest - $cnt,
                ]);
        }

        OrderAfterCreateJob::dispatch(compact('tokenPay', 'userId'))->delay(now()->addSeconds(5));


        return compact('tokenPay');
    }
}
