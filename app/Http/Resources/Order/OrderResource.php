<?php

namespace App\Http\Resources\Order;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'order_id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'tokenPay' => $this->remember_token,
            'totalPrice' => Order::totalPrice($this->remember_token),
            'products' => OrderProductsResource::collection($this->products),
        ];
    }
}
