<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * Thrown when an invalid card name is provided
 *
 * @package Matcher\Payment\Domain\Exception
 * @codeCoverageIgnore
 */
final class InvalidCardNumberException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_card_number';
}
