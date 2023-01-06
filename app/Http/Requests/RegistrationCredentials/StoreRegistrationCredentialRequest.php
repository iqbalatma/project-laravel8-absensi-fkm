<?php

namespace App\Http\Requests\RegistrationCredentials;

use App\Http\Requests\FormRequestAPI;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationCredentialRequest extends FormRequestAPI
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
            "role_id" => "numeric|required",
            "organization_id" => "numeric|required",
            "limit" => "required|numeric",
        ];
    }
}
