<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class FormRequestAPI extends FormRequest {

  function failedValidation(Validator $validator)
  {
    if ($this->expectsJson()) {
      $errors = (new ValidationException($validator))->errors();
      throw new HttpResponseException(
        response()->json([
          'error' => [
            'status_code' => $this->code != 0 ? $this->code : 406,
            'message' => 'Error Found.',
            'error' => $errors
          ]
        ])->setStatusCode(406)
      );
    }
    parent::failedValidation($validator);
  }
}
?>