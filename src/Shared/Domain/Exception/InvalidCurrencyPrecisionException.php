<?php

namespace Matcher\Shared\Domain\Exception;

/**
 * Thrown when an invalid currency precision is provided
 *
 * @codeCoverageIgnore
 */
final class InvalidCurrencyPrecisionException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_currency_precision';
}
