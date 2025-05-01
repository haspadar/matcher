<?php

namespace Matcher\Reference\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid currency name is provided
 *
 * @package Matcher\Reference\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidCurrencyNameException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_currency_name';
}
