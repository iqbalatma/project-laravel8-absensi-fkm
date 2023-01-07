<?php

namespace App\Http\Requests\Checkin;

use App\Http\Requests\FormRequestAPI;
use Illuminate\Foundation\Http\FormRequest;

class CheckinRequest extends FormRequestAPI
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
            'congress_date' => "date_format:Y-m-d"
        ];
    }
}
