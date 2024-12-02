<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errors = str_replace("\n", ". \n", implode("\n" , array_map(function ($arr) {
            return implode("\n" , $arr);
        }, $errors)));
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'data' => null,
                    'error' => $errors,
                    'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'request' => request()->fullUrl(),
                    'method' => strtoupper(request()->method()),
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
