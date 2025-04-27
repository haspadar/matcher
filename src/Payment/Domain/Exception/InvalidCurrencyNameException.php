<?php

namespace Matcher\Payment\Domain\Exception;

use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid currency name is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class InvalidCurrencyNameException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_currency_name';
}
