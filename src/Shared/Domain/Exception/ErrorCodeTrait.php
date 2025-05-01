<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\Exception;

trait ErrorCodeTrait
{
    public function code(): string
    {
        return static::ERROR_CODE;
    }
}
