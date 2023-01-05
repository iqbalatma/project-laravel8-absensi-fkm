<?php

namespace App\Http\Requests\Organizations;

use App\Http\Requests\FormRequestAPI;

class StoreOrganizationRequest extends FormRequestAPI
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
            "name" => "max:128|required",
            "shortname" => "max:32|required|unique:organizations,shortname",
            "link_instagram" => "max:128",
            "link_website" => "max:128",
        ];
    }
}
