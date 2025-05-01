<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Shared\Domain\Exception\CurrencyMismatchException;

final class Money implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private Amount $amount;
    private CurrencyCode $currencyCode;
    private CurrencyPrecision $currencyPrecision;

    public function __construct(
        Amount $amount,
        CurrencyCode $currencyCode,
        CurrencyPrecision $currencyPrecision,
    ) {
        $this->currencyCode = $currencyCode;
        $this->currencyPrecision = $currencyPrecision;
        $this->amount = $this->normalizeAmount($amount);
    }

    public function amount(): Amount
    {
        return $this->amount;
    }

    public function currencyCode(): CurrencyCode
    {
        return $this->currencyCode;
    }

    public function currencyPrecision(): CurrencyPrecision
    {
        return $this->currencyPrecision;
    }

    #[\Override]
    public function value(): string
    {
        return $this->currencyCode->value().':'.$this->amount->value();
    }

    public function isSameCurrency(self $other): bool
    {
        return $this->currencyCode->isEquals($other->currencyCode());
    }

    public function isGreaterThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return bccomp(
            $this->amount->value(),
            $other->amount()->value(),
            $this->currencyPrecision->value(),
        ) === 1;
    }

    public function isLessThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return bccomp(
            $this->amount->value(),
            $other->amount()->value(),
            $this->currencyPrecision->value(),
        ) === -1;
    }

    public function add(self $other): self
    {
        $this->assertSameCurrency($other);

        $sum = bcadd(
            $this->amount->value(),
            $other->amount()->value(),
            $this->currencyPrecision->value(),
        );

        return new self(
            new Amount($sum),
            $this->currencyCode,
            $this->currencyPrecision,
        );
    }

    public function sub(self $other): self
    {
        $this->assertSameCurrency($other);

        $difference = bcsub(
            $this->amount->value(),
            $other->amount()->value(),
            $this->currencyPrecision->value(),
        );

        return new self(
            new Amount($difference),
            $this->currencyCode,
            $this->currencyPrecision,
        );
    }

    /**
     * @codeCoverageIgnore
     */
    private function assertSameCurrency(self $other): void
    {
        if (!$this->isSameCurrency($other)) {
            throw new CurrencyMismatchException(
                sprintf(
                    'Cannot compare Money objects with different currencies: %s vs %s',
                    $this->currencyCode->value(),
                    $other->currencyCode()->value(),
                )
            );
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function normalizeAmount(Amount $amount): Amount
    {
        $value = $amount->value();

        if (!str_contains($value, '.')) {
            return new Amount($value);
        }

        [$integerPart, $decimalPart] = explode('.', $value . '.');  // Добавляем точку, чтобы избежать ошибки

        $precision = $this->currencyPrecision->value();

        if (strlen($decimalPart) > $precision) {
            $decimalPart = substr($decimalPart, 0, $precision);
        }

        $normalized = $decimalPart === ''
            ? $integerPart
            : $integerPart.'.'.$decimalPart;

        return new Amount($normalized);
    }
}
