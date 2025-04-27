<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyPrecisionException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class CurrencyPrecision implements ValueObjectInterface
{
    private int $precision;

    public function __construct(int $precision)
    {
        $this->validate($precision);

        $this->precision = $precision;
    }

    public function value(): int
    {
        return $this->precision;
    }

    private function validate(int $precision): void
    {
        if ($precision < 0 || $precision > 18) {
            throw new InvalidCurrencyPrecisionException("Precision must be between 0 and 18");
        }
    }
}
