<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\FormRequestAPI;
use App\Repositories\RegistrationCredentialRepository;

class StoreRegistrationRequest extends FormRequestAPI
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $regCred = $this->route("credential");
        if (!(new RegistrationCredentialRepository())->getDataByToken($regCred)) {
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'generation' => 'required|numeric',
            'phone_number' => 'string',
            'organization_id' => 'numeric',
            'student_id' => 'required|numeric',
        ];
    }
}
