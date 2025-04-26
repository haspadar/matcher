<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;

final class CurrencyCode
{
    private string $code;

    public function __construct(string $code)
    {
        $code = strtoupper(trim($code));

        if (!preg_match('/^[A-Z]{3,6}$/', $code)) {
            throw new InvalidCurrencyCodeException('Currency code must be between 3 and 6 uppercase letters');
        }

        $this->code = $code;
    }

    public function value(): string
    {
        return $this->code;
    }

    public function isEquals(self $other): bool
    {
        return $this->code === $other->value();
    }
}
