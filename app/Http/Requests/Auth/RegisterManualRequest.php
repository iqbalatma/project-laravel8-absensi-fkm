<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequestAPI;

class RegisterManualRequest extends FormRequestAPI
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'generation' => 'required|string',
            'phone_number' => 'string',
            'organization_id' => 'numeric',
            'student_id' => 'required|numeric',
            'role_id' => 'required|numeric',
        ];
    }
}
