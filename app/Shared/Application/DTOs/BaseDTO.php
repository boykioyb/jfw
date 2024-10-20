<?php

namespace App\Shared\Application\DTOs;

abstract class BaseDTO
{
    abstract public static function fromRequest(mixed $request);
}
