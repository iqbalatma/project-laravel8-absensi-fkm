<?php

namespace App\Http\Requests\CheckoutAllUsers;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutAllUserRequest extends FormRequest
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
            "congress_date" => "required"
        ];
    }
}
