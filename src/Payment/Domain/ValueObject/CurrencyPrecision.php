<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyPrecisionException;

final class CurrencyPrecision
{
    private int $precision;

    public function __construct(int $precision)
    {
        if ($precision < 0 || $precision > 18) {
            throw new InvalidCurrencyPrecisionException("Precision must be between 0 and 18");
        }

        $this->precision = $precision;
    }

    public function value(): int
    {
        return $this->precision;
    }

    public function isEquals(self $other): bool
    {
        return $this->precision === $other->value();
    }
}
