<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationCredentialResource extends JsonResource
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
            'token' => $this->token,
            'is_active' => $this->is_active,
            'role_id' => $this->role_id,
            'role_name' => $this->role->name,
            'limit' => $this->limit,
            'created_at' => $this->created_at->format(config('app.datetime_format')),
            'updated_at' =>  $this->updated_at->format(config('app.datetime_format')),
            'organization' => $this->organization,
        ];
    }
}
