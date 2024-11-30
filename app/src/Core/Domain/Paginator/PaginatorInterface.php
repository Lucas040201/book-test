<?php

namespace Core\Domain\Paginator;

interface PaginatorInterface
{
    function getNextPage();
    function getPreviousPage();
    function getPageSize();
    function getPage();
}
