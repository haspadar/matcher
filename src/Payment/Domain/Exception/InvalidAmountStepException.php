<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Tests\Payment\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid amount step is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
class InvalidAmountStepException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_amount_step';
}
