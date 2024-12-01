<?php

namespace Core\Domain\Paginator;

interface PaginatorInterface
{
    function getPreviousPage();
    function getPageSize();
    function getPage();

    function getParams(): ?array;
}
