<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidAmountException;
use Matcher\Shared\Domain\ValueObject\Amount;

final class PositiveAmount extends Amount
{
    public function __construct(string|int $amount)
    {
        parent::__construct($amount);

        if (!$this->isPositive()) {
            throw new InvalidAmountException('PositiveAmount must be greater than zero');
        }
    }
}
