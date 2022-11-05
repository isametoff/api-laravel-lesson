<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;

class IndexOrder extends Controller
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

    public function __invoke(StoreOrderRequest $request)
    {
        $data = $request->validated();
        return $data;
        return 'Order';
    }
}