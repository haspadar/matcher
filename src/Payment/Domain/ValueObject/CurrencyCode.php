<?php

namespace Matcher\Payment\Domain\ValueObject;

use InvalidArgumentException;
use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;

class CurrencyCode
{
    private string $value;

    public function __construct(string $value)
    {
        $value = strtoupper(trim($value));

        if (!preg_match('/^[A-Z]{3,6}$/', $value)) {
            throw new InvalidCurrencyCodeException('Currency code must be between 3 and 6 uppercase letters');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(CurrencyCode $other): bool
    {
        return $this->value === $other->value();
    }
}
