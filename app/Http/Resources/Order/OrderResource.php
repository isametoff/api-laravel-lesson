<?php

namespace App\Http\Resources\Order;

use App\Actions\Orders\Index as IndexOrderAction;
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
            'orderId' => $this->id,
            'totalPrice' => IndexOrderAction::totalPrice($this->id),
            'created' => $this->created_at->diffForHumans(),
            'count' => count($this->products),
            'products' => OrderProductsResource::collection($this->products),
        ];
    }
}