<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid user id is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidUserIdException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_user_id';
}
