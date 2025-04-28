<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\Exception;

use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * @codeCoverageIgnore
 */
class InvalidUrlException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_url';
}
