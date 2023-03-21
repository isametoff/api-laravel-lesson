<?php

namespace App\Http\Resources\Products;

use App\Actions\Index;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexProductsResource extends JsonResource
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
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'sex' => $this->sex,
            'dob_year' => $this->dob_year,
            // 'dob_year' => DateTime::createFromFormat('d/m/Y', $this->dob_year)->format('Y'),
            // 'dob_year' => Carbon::createFromFormat('d-m-Y', DateTime::createFromFormat('d/m/Y', $this->dob_year)->format('d-m-Y'))->format('Y'),
            // 'dob_year' => Carbon::createFromFormat('Y-m-d', $this->dob_year)->format('Y'),
            'state' => $this->state,
            'sity' => $this->sity,
            'dl' => strlen($this->dl) > 0,
            'zip' => $this->zip,
            'price' => $this->price,
        ];
    }
}
