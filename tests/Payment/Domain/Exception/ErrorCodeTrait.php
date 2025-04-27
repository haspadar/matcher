<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Exception;

trait ErrorCodeTrait
{
    public function code(): string
    {
        return static::ERROR_CODE;
    }
}
