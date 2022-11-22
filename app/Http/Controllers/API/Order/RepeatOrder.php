<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\RepeatOrder as RepeatOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;

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

    public function __invoke(LoadOrderIdRequest $request, RepeatOrderAction $repeatOrderAction)
    {
        $orderId = $repeatOrderAction($request->validated());
        return compact('orderId');
    }
}