<?php

namespace Core\Domain\Paginator;

readonly class Paginator implements PaginatorInterface
{

    public function __construct(
        private int  $currentPage,
        private int  $perPage,
        private ?int $nextPage = null
    )
    {
    }

    function getNextPage()
    {
        return $this->nextPage;
    }

    function getPreviousPage()
    {
        return $this->currentPage - 1;
    }

    function getPageSize()
    {
        return $this->perPage;
    }

    function getPage()
    {
        return $this->currentPage;
    }
}
