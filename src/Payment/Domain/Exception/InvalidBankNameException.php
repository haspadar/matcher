<?php

namespace Matcher\Payment\Domain\Exception;

use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid bank name is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class InvalidBankNameException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_bank_name';
}
