<?php

namespace App\Http\Requests\UserManagement;

use App\Http\Requests\FormRequestAPI;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequestAPI
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
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed",
            "student_id" => "numeric",
            "generation" => "numeric",
            "organization_id" => "numeric",
            "role_id" => "numeric",
            "phone_number" => ""
        ];
    }
}
