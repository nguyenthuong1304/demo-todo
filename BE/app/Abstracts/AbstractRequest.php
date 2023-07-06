<?php

namespace App\Abstracts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequest extends FormRequest {

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = array_map(fn($e) => $e[0], $validator->errors()->toArray());
        $response = new JsonResponse([
            'status' => 422,
            'data' => $errors,
            'message' => __('messages.validation_failed'),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
