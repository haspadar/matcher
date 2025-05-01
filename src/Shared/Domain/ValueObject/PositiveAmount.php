<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidPositiveAmountException;

final class PositiveAmount
{
    private Amount $amount;

    public function __construct(string|int $value)
    {
        $this->amount = new Amount($value);

        if (!$this->amount->isPositive()) {
            throw new InvalidPositiveAmountException('PositiveAmount must be greater than zero');
        }
    }

    public function value(): string
    {
        return $this->amount->value();
    }
}
