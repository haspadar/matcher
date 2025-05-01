<?php

namespace Matcher\Shared\Domain\Exception;

/**
 * @codeCoverageIgnore
 */
final class CurrencyMismatchException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'currency_mismatch';
}
