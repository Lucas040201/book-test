<?php

namespace Core\Domain\Paginator;

readonly class Paginator implements PaginatorInterface
{

    public function __construct(
        private int  $page,
        private int  $perPage,
        private ?array $params = null
    )
    {
    }

    function getPreviousPage()
    {
        return $this->page - 1;
    }

    function getPageSize()
    {
        return $this->perPage;
    }

    function getPage()
    {
        return $this->page;
    }

    function getParams(): ?array
    {
        return $this->params;
    }
}
