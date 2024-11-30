<?php

namespace App\Http\Response;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="DefaultResponse",
 *     type="object",
 *     @OA\Property(
 *         property="success",
 *         type="boolean",
 *         description="Indicates that the request was successful"
 *     ),
 *     @OA\Property(
 *         property="request",
 *         type="string",
 *         description="Requested Url",
 *         example="http://localhost/api/v1"
 *     ),
 *     @OA\Property(
 *         property="method",
 *         description="Requested Method",
 *         type="string",
 *         example="Get"
 *     ),
 *     @OA\Property(
 *          property="code",
 *          description="Status code",
 *          type="string",
 *          example="200"
 *      ),
 *     @OA\Property(
 *         property="error",
 *         description="Error Message",
 *         type="string",
 *         nullable=true,
 *     ),
 *      @OA\Property(
 *           property="data",
 *           description="Api data response",
 *           type="object",
 *           nullable=true,
 *       )
 * )
 */
class DefaultResponse
{
    /**
     * @var array
     */
    private $parameters;

    public function __construct(
        $data = null,
        bool $success = true,
        string $error = '',
        int $code = 200
    )
    {
        $this->parameters = [
            'success' => $success,
            'request' => request()->fullUrl(),
            'method' => strtoupper(request()->method()),
            'code' => ($code > 0)? $code : 500,
            'error' => $error,
        ];

        $this->parameters['data'] = (empty($data))
            ? null
            : $data;
    }

    public function __get($parameter)
    {
        return $this->parameters[$parameter] ?? null;
    }

    public function toArray(): array
    {
        return $this->parameters;
    }
}
