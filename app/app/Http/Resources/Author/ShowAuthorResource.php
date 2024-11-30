<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ShowAuthorResource",
 *     title="Author Resource",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Author Uuid",
 *         example="7aa02c28-f2bd-387c-9c8c-b2069e0e6159"
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Author Name",
 *          example="John Doe"
 *     ),
 *     @OA\Property(
 *           property="biography",
 *           type="string",
 *           description="Author Bio",
 *      ),
 * )
 */
class ShowAuthorResource extends JsonResource
{
    public function toArray(Request $request)
    {

    }
}
