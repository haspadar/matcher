<?php

namespace Matcher\Shared\Domain\Exception;

/**
 * Thrown when an invalid currency code is provided
 *
 * @codeCoverageIgnore
 */
final class InvalidCurrencyCodeException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_currency_code';
}
