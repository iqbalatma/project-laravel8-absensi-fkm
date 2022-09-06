<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CongressDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'h_day' => $this->h_day,
            'location' => $this->location,
        ];
    }

    public function with($request)
    {
        return [
            'error' => 0
        ];
    }
}
