<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'personal_token' => $this->personal_token,
            'student_id' => $this->student_id,
            'generation' => $this->generation,
            'phone_number' => $this->phone_number,
            'organization_id' => $this->organization_id,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'created_at' => $this->created_at->format(config('app.datetime_format')),
            'updated_at' => $this->updated_at->format(config('app.datetime_format'))
        ];
    }
}
