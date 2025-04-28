<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidAmountException;

class Amount implements ValueObjectInterface
{
    /**
     * @var numeric-string
     */
    private string $amount;

    public function __construct(string|int $amount)
    {
        $amount = (string) $amount;

        $this->validate($amount);

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

    /**
     * @param  string  $amount
     * @return void
     * @throws InvalidAmountException
     */
    public function validate(string $amount): void
    {
        if (!preg_match('/^-?\d+(\.\d+)?$/', $amount)) {
            throw new InvalidAmountException('Amount must be numeric');
        }
    }

}
