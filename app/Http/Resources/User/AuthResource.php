<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd("🚀 ~ file: AuthResource.php ~ line 16 ~ request", $request);
        return [
            'login' => $this->login,
            'email' => $this->email,
        ];
    }
}
