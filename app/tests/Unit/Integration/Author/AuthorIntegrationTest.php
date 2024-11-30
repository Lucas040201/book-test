<?php

namespace Tests\Unit\Integration\Author;

use App\Exception\AuthorNotFoundIntegrationException;
use App\Integration\AuthorIntegration;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Providers\IntegrationProvider;
use Tests\TestCase;

class AuthorIntegrationTest extends TestCase
{

    private AuthorIntegration $integration;


    protected function setUp(): void
    {
        parent::setUp();


        $this->integration = new AuthorIntegration();
    }

    #[DataProvider('authorCasesProvider')]
    public function testAuthorIntegrationCases(array $authorResponse): void
    {
        $authorName = 'Machado de Assis';
        $authorBio = 'this is a bio';
        $bookTitle = 'Quincas Borba';

        Http::fake([
            "*" => Http::sequence()->push(IntegrationProvider::getBookResponse())->push($authorResponse)
        ]);
        $response = $this->integration->getBookAuthor($bookTitle);
        $this->assertEquals($authorName, $response->name);
        $this->assertEquals($authorBio, $response->biography);
    }

    public static function authorCasesProvider(): array
    {
        return [
            'testFindAnAuthor' => [
                'authorResponse' => IntegrationProvider::getAuthorResponse(),
            ],
            'testFindAnAuthorWithDifferentStructure' => [
                'authorResponse' => [
                    'personal_name' => 'Machado de Assis',
                    'bio' => ['value' => 'this is a bio']
                ]
            ],
        ];
    }

    #[DataProvider('authorErrorsProvider')]
    public function testAuthorsIntegrationErrorsCases(array $bookResponse, array $authorResponse): void
    {
        $this->expectException(AuthorNotFoundIntegrationException::class);
        $this->expectExceptionMessage('No authors found for this book.');

        Http::fake([
            "*" => Http::sequence()->push($bookResponse)->push($authorResponse)
        ]);
        $this->integration->getBookAuthor('name');
    }

    public static function authorErrorsProvider(): array
    {
        return [
            'testThrowErrorWhenBookFieldsIsEmpty' => [
                'bookResponse' => [],
                'authorResponse' => IntegrationProvider::getAuthorResponse(),
            ],
            'testThrowErrorWhenAuthorFieldsIsEmpty' => [
                'bookResponse' => IntegrationProvider::getBookResponse(),
                'authorResponse' => []
            ]
        ];
    }
}
