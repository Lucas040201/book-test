<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ArrayOfBooks",
 *     title="Aray of Books",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/ShowBookResource")
 * ),
 * @OA\Schema(
 *     schema="BookCollectionResource",
 *     title="Book Resource",
 *     @OA\Property(
 *          property="count",
 *          description="Page to retrieve",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *           property="currentPage",
 *           description="Limit of Book per page",
 *           type="integer"
 *       ),
 *       @OA\Property(
 *            property="lastPage",
 *            description="Last Page",
 *            type="integer"
 *        ),
 *        @OA\Property(
 *            property="items",
 *            ref="#/components/schemas/ArrayOfBooks"
 *        )
 * )
 */
class BookCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $this->resource;
        $formatedItems = $paginator->getCollection()->transform(function ($item) use ($request) {
            return (new ShowBookResource($item->toArray()))->toArray($request);
        })?->toArray();

        return [
            'count' => $paginator->total(),
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'items' => $formatedItems
        ];
    }
}
