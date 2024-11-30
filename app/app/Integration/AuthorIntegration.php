<?php

namespace App\Integration;

use App\Exception\AuthorNotFoundIntegrationException;
use App\Integration\DTO\AuthorKeyDTO;
use Core\Integration\Author\AuthorIntegrationInterface;
use Core\Integration\Author\DTO\AuthorDataDTO;
use Illuminate\Support\Facades\Http;

class AuthorIntegration implements AuthorIntegrationInterface
{

    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INTEGRATION_BASE_URL');
    }

    public function getBookAuthor(string $bookTitle): AuthorDataDTO
    {

        $bookInfo = $this->searchBook($bookTitle);
        $response = Http::get("$this->baseUrl/authors/$bookInfo->authorKey.json");

        $apiResponse = $response->json();

        if(!key_exists('personal_name', $apiResponse) || !key_exists('bio', $apiResponse)) {
            throw new AuthorNotFoundIntegrationException();
        }

        if(is_array($apiResponse['bio'])) {
            $authorBio = $apiResponse['bio']['value'];
        } else {
            $authorBio = $apiResponse['bio'];
        }

        return new AuthorDataDTO($apiResponse['personal_name'], $authorBio);
    }

    private function searchBook(string $bookTitle): AuthorKeyDTO
    {
        $response = Http::get("$this->baseUrl/search.json?q=$bookTitle&fields=key,title,author_name,author_key");
        $jsonResponse = $response->json();

        if(!key_exists('docs', $jsonResponse) || empty($jsonResponse['docs'])) {
            throw new AuthorNotFoundIntegrationException();
        }

        $bookInfo = array_shift($jsonResponse['docs']);

        if(empty($bookInfo['author_key']) && !is_array($bookInfo['author_key'])) {
            throw new AuthorNotFoundIntegrationException();
        }

        $authorKey = array_shift($bookInfo['author_key']);

        return new AuthorKeyDTO($authorKey);
    }
}
