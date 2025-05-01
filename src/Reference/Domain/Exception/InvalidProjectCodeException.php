<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid project name is provided
 *
 * @package Matcher\Reference\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidProjectCodeException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_project_code';
}
