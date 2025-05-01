<?php

namespace Matcher\Reference\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid currency precision is provided
 *
 * @package Matcher\Reference\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidCurrencyPrecisionException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_currency_precision';
}
