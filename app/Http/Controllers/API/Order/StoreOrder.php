<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Store;
use App\Actions\Orders\Viability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;

class StoreOrder extends Controller
{
    public function __invoke(StoreOrderRequest $request, Store $storeAction, Viability $viabilityAction)
    {
        $viability = $viabilityAction($request['ids']);

        if ($viability['isProduct'] === true && $viability['isBalance'] === true) {
            return $storeAction($request['ids'], $viability['amount']);
        };
        return $viability;
    }
}