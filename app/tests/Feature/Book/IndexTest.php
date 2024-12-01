<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class IndexTest extends TestCase
{
    #[DataProvider('paginationProvider')]
    public function testBookPagination($params, $expectedPage, $countOfUsers): void
    {
        Book::factory()->count($countOfUsers)->create();
        $headers = [
            'Accept' => 'application/json',
        ];

        $queryParams = http_build_query($params);

        $response = $this->get("api/v1/book?$queryParams", $headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success",
            "request",
            "method",
            "code",
            "error"
        ]);

        $response->assertJson([
            'data' => [
                'currentPage' => $expectedPage,
            ]
        ]);
    }

    public static function paginationProvider(): array
    {
        return [
            'testPaginationWithSearchParam' => [
                'params' => [
                    'search' => 'test'
                ],
                'expectedPage' => 1,
                'countOfUsers' => 10
            ],
            'testPaginationWithSortParam' => [
                'params' => [
                    'sort' => 'desc'
                ],
                'expectedPage' => 1,
                'countOfUsers' => 15
            ],
            'testPaginationGetNextPage' => [
                'params' => [
                    'page' => 2
                ],
                'expectedPage' => 2,
                'countOfUsers' => 15
            ]
        ];
    }
}
