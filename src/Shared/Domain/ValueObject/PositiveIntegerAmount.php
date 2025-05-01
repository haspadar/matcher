<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidPositiveIntegerAmountException;

final class PositiveIntegerAmount
{
    private PositiveAmount $positiveAmount;

    public function __construct(string|int $amount)
    {
        $this->positiveAmount = new PositiveAmount($amount);

        if (!preg_match('/^\d+(\.0+)?$/', (string)$amount)) {
            throw new InvalidPositiveIntegerAmountException('PositiveIntegerAmount must be an integer');
        }
    }

    public function value(): int
    {
        return (int)$this->positiveAmount->value();
    }

}
