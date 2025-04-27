<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidBankNameException;
use Matcher\Shared\Domain\ValueObject\ValueObjectEqualsTrait;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class BankName implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private string $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        $this->validate($name);
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    private function validate(string $name): void
    {
        if (!preg_match('/^[a-zA-Z\s,.\-]+$/', $name)) {
            throw new InvalidBankNameException('Bank name must contain only Latin letters, spaces, commas, periods, or dashes.');
        }

        if (strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidBankNameException('Bank name must be between 2 and 255 characters.');
        }
    }

}
