<?php

namespace App\Http\Requests\MyProfile;

use App\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateMyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Hash::check($this->password, Auth::user()->password)) {
            throw new UnauthorizedException();
        }
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
            "name" => "",
            "student_id" => "numeric",
            "generation" => "numeric",
            "phone_number" => "",
            "new_password" => "confirmed",
        ];
    }
}
