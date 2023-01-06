<?php

namespace App\Http\Requests\Organizations;

use App\Exceptions\EmptyDataException;
use App\Http\Requests\FormRequestAPI;
use Illuminate\Validation\Rule;

class UpdateOrganizationRequest extends FormRequestAPI
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
            "name" => "max:128",
            "shortname" => ["max:32", Rule::unique("organizations")->ignore($this->id)],
            "link_instagram" => "max:128",
            "link_website" => "max:128",
        ];
    }
}
