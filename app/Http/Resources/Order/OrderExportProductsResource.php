<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderExportProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            $this->last_name . ' ' . $this->first_name . '|' . $this->sex . '|' . $this->dob_year . '|' .
            $this->state . '|' . $this->sity . '|' . $this->dl . '|' . $this->zip . '|' .
            $this->country . '|' .
            str_replace(",", '', str_replace("\n", ' ', $this->adress)) . '|' .
            str_replace(",", '', str_replace("\n", ' ', $this->adress2)) . '|' .
            $this->work_phone . '|' . $this->home_phone . '|' . $this->email . '|' .
            $this->marital_status;
        // return [
        //     'full_name' => $this->full_name,
        //     'sex' => $this->sex,
        //     'dob_year' => $this->dob_year,
        //     'state' => $this->state,
        //     'sity' => $this->sity,
        //     'dl' => $this->dl,
        //     'zip' => $this->zip,
        // ];
    }
}
