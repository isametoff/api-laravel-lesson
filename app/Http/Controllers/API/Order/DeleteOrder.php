<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadTokenPayRequest;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class DeleteOrder extends Controller
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

        function productsValue($model, $column, $value)
        {
            return $model->where('id', $column)->value($value);
        }

        $ordersUser = Order::where('user_id', $userId)->where('remember_token', $data['tokenPay'])->delete();
        $message = Order::where('user_id', $userId)->where('remember_token', $data['tokenPay'])
            ->doesntExist() ? 'Успешно удалён' : 'Ошибка при удалении';

        return compact('message');
    }
}
