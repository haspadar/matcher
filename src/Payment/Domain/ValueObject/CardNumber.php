<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCardNumberException;
use Matcher\Shared\Domain\ValueObject\RequisiteInterface;

class CardNumber implements RequisiteInterface
{
    private string $number;

    public function __construct(string $number)
    {
        $number = trim($number);
        $this->validate($number);
        $this->number = $number;
    }

    public function value(): string
    {
        return $this->number;
    }

    public function validate(string $value): void
    {
        if (!preg_match('/^\d{13,19}$/', $value)) {
            throw new InvalidCardNumberException('Card number must be between 13 and 19 digits');
        }
    }

    /**
     * Get the BIN (first 6 digits) from the card number.
     */
    public function getBin(): string
    {
        return substr($this->number, 0, 6);
    }
}
