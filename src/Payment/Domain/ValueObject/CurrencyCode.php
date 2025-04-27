<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Shared\Domain\ValueObject\ValueObjectEqualsTrait;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class CurrencyCode implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private string $code;

    public function __construct(string $code)
    {
        $code = strtoupper(trim($code));
        $this->validate($code);
        $this->code = $code;
    }

    public function value(): string
    {
        return $this->code;
    }

    public function validate(string $code): void
    {
        if (!preg_match('/^[A-Z]{3,6}$/', $code)) {
            throw new InvalidCurrencyCodeException('Currency code must be between 3 and 6 uppercase letters');
        }
    }
}
