<?php

namespace Core\UseCases\DTO;

abstract class BaseDTO
{
    public function __get(string $prop): mixed
    {
        return $this->{$prop};
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
