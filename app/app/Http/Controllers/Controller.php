<?php

namespace App\Http\Controllers;

use App\Http\Response\DefaultResponse;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function response(DefaultResponse $response): JsonResponse
    {
        $jsonOptions = JSON_UNESCAPED_UNICODE + JSON_PRESERVE_ZERO_FRACTION;
        return response()->json($response->toArray(), $response->code, [], $jsonOptions);
    }
}
