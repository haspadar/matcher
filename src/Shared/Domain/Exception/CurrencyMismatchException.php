<?php

namespace Matcher\Shared\Domain\Exception;

use Matcher\Payment\Domain\Exception\DomainException;
use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when attempting to operate on Money objects with different currencies
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class CurrencyMismatchException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'currency_mismatch';
}
