<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'string',
            'student_id'=> 'numeric|digits:8',
            'generation' => 'numeric|digits:4',
            'phone_number'=> '',
            'organization_id'=>'numeric',
            'role_id'=> 'numeric'
        ];
    }
}
