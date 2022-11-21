<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\Order\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\NullOrderIdRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
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

    public function __invoke(NullOrderIdRequest $request, Order $orders, Products $products, OrderProducts $orderProducts)
    {
        $data = $request->validated();
        $user = Auth::user()->id;

        $ordersItems = $orders->where('user_id', $user)->whereIn('status', [Status::WAITING, Status::ADDED]);
        $ordersItemsDesc = $ordersItems->orderByDesc('updated_at')->first();
        $ordersProducts = $orders->orderProducts($ordersItemsDesc->id);

        $orderItem = OrderResource::collection($ordersProducts)->first();

        return compact('orderItem');
    }
}
