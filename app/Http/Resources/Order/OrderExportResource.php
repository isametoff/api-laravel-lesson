<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderExportResource extends JsonResource
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
            'full_name|sex|dob_year|state|sity|dl|zip|country|address|address2|work_phone|home_phone|email|marital_status',
            OrderExportProductsResource::collection($this->products)
        ];
    }
}
