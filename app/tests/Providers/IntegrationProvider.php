<?php

namespace Tests\Providers;

class IntegrationProvider
{
    public static function getAuthorResponse(): array
    {
        return [
            'personal_name' => 'Machado de Assis',
            'bio' => 'this is a bio'
        ];
    }

    public static function getBookResponse(): array
    {
        return [
            "docs" => [
                [
                    "author_key" => [
                        "OL93286A"
                    ],
                ],
            ]
        ];
    }
}
