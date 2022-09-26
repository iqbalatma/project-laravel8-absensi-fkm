<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ManualRegistrationStoreRequest extends FormRequest
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
            'name' => 'required|string|max:128',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'generation' => 'string',
            'phone_number' => 'string',
            'organization_id' => 'numeric',
            'student_id' => 'numeric',
            'role_id' => 'required'
        ];
    }
}
