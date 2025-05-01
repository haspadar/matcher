<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Reference\Domain\Exception\DomainException;
use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid amount step is provided
 *
 * @package Matcher\Reference\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidAmountStepException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_amount_step';
}
