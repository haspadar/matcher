<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Exception;

use Matcher\Shared\Domain\Exception\ErrorCodeTrait;

/**
 * @codeCoverageIgnore
 */
final class InvalidDepositAmount extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'invalid_deposit_amount';
}
