<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateBookRequest",
 *     title="Update Book",
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
 * )
 */
class UpdateBookRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
        ];
    }
}
