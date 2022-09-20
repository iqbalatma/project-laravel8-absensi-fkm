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
            'created_at' => $this->created_at->format(config('app.datetime_format')),
            'updated_at' => $this->updated_at->format(config('app.datetime_format'))
        ];
    }
}
