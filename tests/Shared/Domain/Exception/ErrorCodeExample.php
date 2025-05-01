<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

class ErrorCodeExample
{
    use ErrorCodeTrait;

    public const string ERROR_CODE = '1234';
}
