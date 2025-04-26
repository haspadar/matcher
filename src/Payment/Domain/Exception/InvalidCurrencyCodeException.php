<?php

namespace Matcher\Payment\Domain\Exception;

/**
 * Thrown when an invalid currency code is provided.
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class InvalidCurrencyCodeException extends DomainException
{
    public const string ERROR_CODE = 'invalid_currency_code';

    /**
     * Returns a specific error code for this exception.
     */
    public function code(): string
    {
        return self::ERROR_CODE;
    }
}
