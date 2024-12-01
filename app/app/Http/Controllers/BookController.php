<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookCollectionResource;
use App\Http\Resources\Book\ShowBookResource;
use App\Http\Response\DefaultResponse;
use Core\Domain\Paginator\Paginator;
use Core\UseCases\Book\CreateBookUseCase;
use Core\UseCases\Book\DeleteBookUseCase;
use Core\UseCases\Book\DTO\CreateBookDTO;
use Core\UseCases\Book\DTO\UpdateBookDTO;
use Core\UseCases\Book\RetrieveBookUseCase;
use Core\UseCases\Book\ShowBookUseCase;
use Core\UseCases\Book\UpdateBookUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BookController extends Controller
{
    /**
     * @OA\Post(
     *     path="v1/book",
     *     summary="Create a Book",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CreateBookRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created Succesfully",
     *         @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                           property="request",
     *                           example="http://localhost/api/v1/book"
     *                      ),
     *                      @OA\Property(
     *                          property="data",
     *                          ref="#/components/schemas/ShowBookResource"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          example="201"
     *                      ),
     *                       @OA\Property(
     *                           property="method",
     *                           example="POST"
     *                       )
     *                  )
     *              }
     *           )
     *     ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Error",
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                    @OA\Schema(
     *                        @OA\Property(
     *                            property="code",
     *                            example="500"
     *                        ),
     *                        @OA\Property(
     *                            property="method",
     *                            example="Delete"
     *                        ),
     *                        @OA\Property(
     *                             property="success",
     *                             example="false"
     *                         ),
     *                        @OA\Property(
     *                            property="error",
     *                            example="Internal Error"
     *                        )
     *                    )
     *                }
     *            )
     *      )
     *  )
     * @param CreateBookRequest $request
     * @param CreateBookUseCase $createBookUseCase
     * @return JsonResponse
     */
    public function create(CreateBookRequest $request, CreateBookUseCase $createBookUseCase): JsonResponse
    {
        try {
            $validated = $request->validated();
            $dto = new CreateBookDto(...$validated);
            $response = $createBookUseCase->handle($dto);
            return $this->response(
                new DefaultResponse(
                    new ShowBookResource($response),
                    code: 201
                )
            );
        } catch (\Exception $e) {
            return $this->response(new DefaultResponse(
                success: false,
                error: $e->getMessage(),
                code: $e->getCode()
            ));
        }
    }

    /**
     * @OA\Get(
     *     path="v1/book/{bookId}",
     *     summary="Retrieve a book",
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         description="Book Uuid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Founded Book",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="request",
     *                          example="http://localhost/api/v1/book/7aa02c28-f2bd-387c-9c8c-b2069e0e6159"
     *                      ),
     *                      @OA\Property(
     *                          property="data",
     *                          ref="#/components/schemas/ShowBookResource"
     *                      ),
     *                  )
     *              }
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Book not found",
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                   @OA\Schema(
     *                       @OA\Property(
     *                           property="code",
     *                           example="404"
     *                       ),
     *                       @OA\Property(
     *                            property="success",
     *                            example="false"
     *                        ),
     *                       @OA\Property(
     *                           property="error",
     *                           example="Resource Book not found"
     *                       )
     *                   )
     *               }
     *           )
     *     )
     * )
     * @param string $bookId
     * @param ShowBookUseCase $showBookUseCase
     * @return JsonResponse
     */
    public function show(string $bookId, ShowBookUseCase $showBookUseCase): JsonResponse
    {
        try {
            $response = $showBookUseCase->handle($bookId);
            return $this->response(
                new DefaultResponse(
                    new ShowBookResource($response)
                )
            );
        } catch (\Exception $e) {
            return $this->response(new DefaultResponse(
                success: false,
                error: $e->getMessage(),
                code: $e->getCode()
            ));
        }
    }

    /**
     * @OA\Delete(
     *     path="v1/book/{bookId}",
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         description="Book Uuid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="DeletedBook",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                           property="request",
     *                           example="http://localhost/api/v1/book/7aa02c28-f2bd-387c-9c8c-b2069e0e6159"
     *                      ),
     *                      @OA\Property(
     *                          property="method",
     *                          example="Delete"
     *                      )
     *                  )
     *              }
     *          )
     *      ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Error",
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                   @OA\Schema(
     *                       @OA\Property(
     *                           property="code",
     *                           example="500"
     *                       ),
     *                       @OA\Property(
     *                           property="method",
     *                           example="Delete"
     *                       ),
     *                       @OA\Property(
     *                            property="success",
     *                            example="false"
     *                        ),
     *                       @OA\Property(
     *                           property="error",
     *                           example="Internal Error"
     *                       )
     *                   )
     *               }
     *           )
     *     )
     * )
     * @param string $bookId
     * @param DeleteBookUseCase $deleteBookUseCase
     * @return JsonResponse
     */
    public function delete(string $bookId, DeleteBookUseCase $deleteBookUseCase): JsonResponse
    {
        try {
            $deleteBookUseCase->handle($bookId);
            return $this->response(new DefaultResponse());
        } catch (\Exception $e) {
            return $this->response(new DefaultResponse(
                success: false,
                error: $e->getMessage(),
                code: $e->getCode()
            ));
        }
    }

    /**
     * @OA\Get(
     *     path="v1/book",
     *     summary="Retrieves a book pagination",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit of Book per page",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *           name="sort",
     *           in="query",
     *           description="Book Sort",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *            name="search",
     *            in="query",
     *            description="Search string",
     *            required=false,
     *            @OA\Schema(type="string")
     *        ),
     *      @OA\Response(
     *          response=200,
     *          description="Pagination Result",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="request",
     *                          example="http://localhost/api/v1/book?search=test&sort=desc&page=1&limit=10"
     *                      ),
     *                      @OA\Property(
     *                          property="data",
     *                          ref="#/components/schemas/BookCollectionResource"
     *                      ),
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Error",
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                    @OA\Schema(
     *                        @OA\Property(
     *                            property="code",
     *                            example="500"
     *                        ),
     *                        @OA\Property(
     *                            property="method",
     *                            example="GET"
     *                        ),
     *                        @OA\Property(
     *                             property="success",
     *                             example="false"
     *                         ),
     *                        @OA\Property(
     *                            property="error",
     *                            example="Internal Error"
     *                        )
     *                    )
     *                }
     *            )
     *      )
     *  )
     *
     * @param string $bookId
     * @param ShowBookUseCase $showBookUseCase
     * @return JsonResponse
     */
    public function index(Request $request, RetrieveBookUseCase $retrieveBookUseCase): JsonResponse
    {
        try {
            $params = $request->query();
            $paginator = new Paginator(
                $params['page'] ?? 1,
                $params['limit'] ?? 10,
                [
                    'query' => $params['search'] ?? '',
                    'sort' => $params['sort'] ?? 'ASC',
                ]
            );
            $response = $retrieveBookUseCase->handle($paginator);
            return $this->response(
                new DefaultResponse(
                    new BookCollectionResource($response)
                )
            );
        } catch (\Exception $e) {
            return $this->response(new DefaultResponse(
                success: false,
                error: $e->getMessage(),
                code: $e->getCode()
            ));
        }

    }

    /**
     * @OA\Put(
     *     path="v1/book/{bookId}",
     *     summary="Update a Book",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/UpdateBookRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created Succesfully",
     *         @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/DefaultResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                           property="request",
     *                           example="http://localhost/api/v1/book"
     *                      ),
     *                      @OA\Property(
     *                          property="data",
     *                          ref="#/components/schemas/ShowBookResource"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          example="200"
     *                      ),
     *                       @OA\Property(
     *                           property="method",
     *                           example="PUT"
     *                       )
     *                  )
     *              }
     *           )
     *     )
     * )
     * @param UpdateBookRequest $request
     * @param string $bookId
     * @param UpdateBookUseCase $updateBookUseCase
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, string $bookId, UpdateBookUseCase $updateBookUseCase): JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['id'] = $bookId;
            $dto = new UpdateBookDto(...$validated);
            $response = $updateBookUseCase->handle($dto);
            return $this->response(
                new DefaultResponse(
                    new ShowBookResource($response),
                )
            );
        } catch (\Exception $e) {
            return $this->response(new DefaultResponse(
                success: false,
                error: $e->getMessage(),
                code: $e->getCode()
            ));
        }
    }

}
