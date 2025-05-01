<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\Exception;

/**
 * @codeCoverageIgnore
 */
final class InvalidPositiveIntegerAmountException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_positive_integer_amount';
}
