<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequestAPI;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordLinkRequest extends FormRequestAPI
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
            "email" => "required|email"
        ];
    }
}
