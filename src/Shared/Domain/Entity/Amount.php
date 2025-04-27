<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\Entity;

use Matcher\Shared\Domain\Exception\InvalidAmountException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

class Amount implements ValueObjectInterface
{
    /**
     * @var numeric-string
     */
    private string $amount;

    public function __construct(string|int $amount)
    {
        $amount = (string) $amount;

        if (!preg_match('/^-?\d+(\.\d+)?$/', $amount)) {
            throw new InvalidAmountException('Amount must be numeric');
        }

        /**
         * @var numeric-string $amount
         */
        $this->amount = $amount;
    }

    /**
     * @return numeric-string
     */
    public function value(): string
    {
        return $this->amount;
    }

    public function isPositive(): bool
    {
        return bccomp($this->amount, '0', 0) === 1;
    }

    public function isNegative(): bool
    {
        return bccomp($this->amount, '0', 0) === -1;
    }

    public function isZero(): bool
    {
        return bccomp($this->amount, '0', 0) === 0;
    }

}
