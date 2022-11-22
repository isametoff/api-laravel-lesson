<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\DeleteOrder as DeleteOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\LoadOrderIdRequest;

class DeleteOrder extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    public function __invoke(LoadOrderIdRequest $request, DeleteOrderAction $deleteOrderAction)
    {
        $message = $deleteOrderAction($request->validated());
        return compact('message');
    }
}