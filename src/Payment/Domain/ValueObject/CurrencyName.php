<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyNameException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

class CurrencyName implements ValueObjectInterface
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) > 255) {
            throw new InvalidCurrencyNameException("Currency name is too long");
        }

        $this->name = ucwords(strtolower($name));
    }

    public function value(): string
    {
        return $this->name;
    }
}
