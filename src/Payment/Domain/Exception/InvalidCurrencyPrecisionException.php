<?php

namespace Matcher\Payment\Domain\Exception;

/**
 * Thrown when an invalid currency precision is provided.
 *
 * @package Matcher\Payment\Domain\Exception
 */
class InvalidCurrencyPrecisionException extends DomainException
{
    public const string ERROR_CODE = 'invalid_currency_precision';

    /**
     * Returns a specific error code for this exception.
     */
    public function code(): string
    {
        return self::ERROR_CODE;
    }
}
