<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\ShowAuthorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ShowBookResource",
 *     title="Book Resource",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Book Uuid",
 *         example="7aa02c28-f2bd-387c-9c8c-b2069e0e6159"
 *     ),
 *     @OA\Property(
 *          property="title",
 *          type="string",
 *          description="Book title",
 *          example="Clean Arch"
 *     ),
 *     @OA\Property(
 *           property="description",
 *           type="string",
 *           description="Book description",
 *           example="Book of Clean Arch"
 *      ),
 *     @OA\Property(
 *            property="quantity",
 *            type="integer",
 *            description="Book Quantity",
 *            example="1"
 *       ),
 *     @OA\Property(
 *            property="price",
 *            type="integer",
 *            description="Book price",
 *            example="100"
 *       ),
 *     @OA\Property(
 *            property="author",
 *            ref="#/components/schemas/ShowAuthorResource",
 *            example="Book Author"
 *       )
 * )
 */
class ShowBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $author = [];
        if(!empty($this->resource['author'])) {
            $author = (new ShowAuthorResource($this->resource['author']))->toArray($request);
        }

        return [
            'id' => $this->resource['uuid'],
            'title' => $this->resource['title'],
            'description' => $this->resource['description'],
            'price' => $this->resource['price'],
            'quantity' => $this->resource['quantity'],
            'author' => $author,
            'created_at' => (new \DateTime($this->resource['created_at']))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->resource['updated_at']))->format('Y-m-d H:i:s'),
        ];
    }
}
