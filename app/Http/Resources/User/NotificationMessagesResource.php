<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BalanceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationMessagesResource extends JsonResource
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
            'id' => $this->id,
            'read' => $this->read,
            'status' => $this->status,
            'balance' => BalanceResource::make($this->transaction),
            'created' => $this->created_at,
            // 'created' => $this->created_at->diffForHumans(),
        ];
    }
}
