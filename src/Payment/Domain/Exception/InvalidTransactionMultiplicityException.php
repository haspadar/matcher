<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid transaction multiplicity is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class InvalidTransactionMultiplicityException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_transaction_multiplicity';
}
