<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\Exception;

/**
 * @codeCoverageIgnore
 */
final class InvalidUuidException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_uuid';
}
