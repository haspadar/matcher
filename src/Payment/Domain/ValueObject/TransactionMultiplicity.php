<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidTransactionMultiplicityException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class TransactionMultiplicity implements ValueObjectInterface
{
    private int $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function validate(int $value): void
    {
        if ($value === 0) {
            throw new InvalidTransactionMultiplicityException('Transaction multiplicity must not be zero');
        }

        if ($value % 10 !== 0) {
            throw new InvalidTransactionMultiplicityException('Transaction multiplicity must be a multiple of 10');
        }
    }
}
