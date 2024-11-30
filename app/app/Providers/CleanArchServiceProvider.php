<?php

namespace App\Providers;

use App\Integration\AuthorIntegration;
use App\Repositories\Eloquent\AuthorEloquentRepository;
use App\Repositories\Eloquent\BookEloquentRepository;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Integration\Author\AuthorIntegrationInterface;
use Illuminate\Support\ServiceProvider;

class CleanArchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            BookRepositoryInterface::class,
            BookEloquentRepository::class
        );

        $this->app->singleton(
            AuthorRepositoryInterface::class,
            AuthorEloquentRepository::class
        );

        $this->app->bind(
            AuthorIntegrationInterface::class,
            AuthorIntegration::class
        );
    }
}
