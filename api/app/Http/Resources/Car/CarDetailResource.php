<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'car_id' => $this->id,
            'model | year' => $this->model . " " . $this->year
        ];
    }
}
