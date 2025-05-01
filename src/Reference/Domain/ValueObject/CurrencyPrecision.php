<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidCurrencyPrecisionException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class CurrencyPrecision implements ValueObjectInterface
{
    private int $precision;

    public function __construct(int $precision)
    {
        $this->validate($precision);

        $this->precision = $precision;
    }

    #[\Override]
    public function value(): int
    {
        return $this->precision;
    }

    private function validate(int $precision): void
    {
        if ($precision < 0 || $precision > 18) {
            throw new InvalidCurrencyPrecisionException('Precision must be between 0 and 18');
        }
    }
}
