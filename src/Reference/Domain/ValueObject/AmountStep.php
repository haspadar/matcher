<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidAmountStepException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class AmountStep implements ValueObjectInterface
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
            throw new InvalidAmountStepException('Amount step must not be zero');
        }

        if ($value % 100 !== 0) {
            throw new InvalidAmountStepException('Amount step must be a multiple of 100');
        }
    }
}
