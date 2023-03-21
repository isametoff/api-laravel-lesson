<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivinessResource extends JsonResource
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
            'user_id' => $this->user_id,
            'browser' => $this->browser,
            'ip' => $this->ip,
            'created_at' => Carbon::parse($this->created_at)->format('l jS \\of F Y h:i:s A'),
        ];
    }
}
