<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidMultiplicityException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class Multiplicity implements ValueObjectInterface
{
    private int $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    #[\Override]
    public function value(): int
    {
        return $this->value;
    }

    private function validate(int $value): void
    {
        if ($value === 0) {
            throw new InvalidMultiplicityException('Multiplicity must not be zero');
        }

        if ($value % 10 !== 0) {
            throw new InvalidMultiplicityException('Multiplicity must be a multiple of 10');
        }
    }
}
