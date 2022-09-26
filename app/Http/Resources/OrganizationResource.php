<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!empty($this->created_at)){
            $this->created_at = $this->created_at->format(config('app.datetime_format'));
        }
        
        if(!empty($this->updated_at)){
            $this->updated_at = $this->updated_at->format(config('app.datetime_format'));
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'link_instagram' => $this->link_instagram,
            'link_website' => $this->link_website,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
