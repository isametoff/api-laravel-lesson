<?php

namespace App\Http\Controllers;

use App\Actions\Index;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ExportRequest;
use App\Http\Resources\Order\OrderExportProductsResource;
use App\Http\Resources\Order\OrderExportResource;
use App\Models\Order;

class Export extends Controller
{
    public function __invoke(ExportRequest $request)
    {
        $data = $request->validated();
        $orderProducts = Order::where('user_id', auth()->id())->where('id', $data['orderId'])->with('products')->get();
        return OrderExportResource::collection($orderProducts);
    }
}
