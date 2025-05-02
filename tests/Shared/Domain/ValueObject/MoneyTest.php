<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\CurrencyMismatchException;
use Matcher\Shared\Domain\ValueObject\Amount;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Shared\Domain\ValueObject\Money;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    private CurrencyCode $usd;
    private CurrencyPrecision $precision;

    #[Test]
    public function canCreateMoney(): void
    {
        $money = new Money(new Amount('100.00'), $this->usd, $this->precision);

        $this->assertSame('100.00', $money->amount()->value());
        $this->assertSame('USD', $money->currencyCode()->value());
        $this->assertSame(2, $money->currencyPrecision()->value());
    }

    #[Test]
    public function throwsExceptionWhenSubtractingDifferentCurrencies(): void
    {
        $money1 = new Money(new Amount('100.00'), new CurrencyCode('USD'), new CurrencyPrecision(2));
        $money2 = new Money(new Amount('50.00'), new CurrencyCode('EUR'), new CurrencyPrecision(2));

        $this->expectException(CurrencyMismatchException::class);

        $money1->sub($money2);
    }

    #[Test]
    public function failsToCompareGreaterThanWithFloatPrecisionLoss(): void
    {
        $money1 = new Money(new Amount('1.0000000000000001'), $this->usd, new CurrencyPrecision(16));
        $money2 = new Money(new Amount('1.0000000000000000'), $this->usd, new CurrencyPrecision(16));

        $this->assertTrue($money1->isGreaterThan($money2)); // bccomp === 1, <=> даст 0
    }

    #[Test]
    public function comparesLessThanWithPrecision(): void
    {
        $money1 = new Money(new Amount('1.0000000000000000'), $this->usd, new CurrencyPrecision(16));
        $money2 = new Money(new Amount('1.0000000000000001'), $this->usd, new CurrencyPrecision(16));

        $this->assertTrue($money1->isLessThan($money2)); // bccomp === -1, <=> даст 0
    }

    #[Test]
    public function throwsExceptionWhenLessThanDifferentCurrencies(): void
    {
        $eur = new CurrencyCode('EUR');
        $moneyUsd = new Money(new Amount('10.00'), $this->usd, $this->precision);
        $moneyEur = new Money(new Amount('5.00'), $eur, $this->precision);

        $this->expectException(CurrencyMismatchException::class);

        $moneyUsd->isLessThan($moneyEur);
    }

    #[Test]
    public function canAddMoneyWithSameCurrency(): void
    {
        $money1 = new Money(new Amount('10.00'), $this->usd, $this->precision);
        $money2 = new Money(new Amount('15.50'), $this->usd, $this->precision);

        $sum = $money1->add($money2);

        $this->assertSame('25.50', $sum->amount()->value());
        $this->assertSame('USD', $sum->currencyCode()->value());
    }

    #[Test]
    public function canSubMoneyWithSameCurrency(): void
    {
        $money1 = new Money(new Amount('20.00'), $this->usd, $this->precision);
        $money2 = new Money(new Amount('5.00'), $this->usd, $this->precision);

        $result = $money1->sub($money2);

        $this->assertSame('15.00', $result->amount()->value());
    }

    #[Test]
    public function canCompareGreaterThan(): void
    {
        $money1 = new Money(new Amount('30.00'), $this->usd, $this->precision);
        $money2 = new Money(new Amount('20.00'), $this->usd, $this->precision);

        $this->assertTrue($money1->isGreaterThan($money2));
    }

    #[Test]
    public function canCompareLessThan(): void
    {
        $money1 = new Money(new Amount('10.00'), $this->usd, $this->precision);
        $money2 = new Money(new Amount('20.00'), $this->usd, $this->precision);

        $this->assertTrue($money1->isLessThan($money2));
    }

    #[Test]
    public function normalizesAmountAccordingToPrecision(): void
    {
        $money = new Money(
            new Amount('123.4567'),
            $this->usd,
            new CurrencyPrecision(2)
        );

        $this->assertSame('123.45', $money->amount()->value());
    }

    #[Test]
    public function throwsExceptionWhenAddingDifferentCurrencies(): void
    {
        $eur = new CurrencyCode('EUR');
        $moneyUsd = new Money(new Amount('10.00'), $this->usd, $this->precision);
        $moneyEur = new Money(new Amount('5.00'), $eur, $this->precision);

        $this->expectException(CurrencyMismatchException::class);

        $moneyUsd->add($moneyEur);
    }

    #[Test]
    public function returnsCorrectValue(): void
    {
        $money = new Money(new Amount('50.00'), $this->usd, $this->precision);

        $this->assertSame('USD:50.00', $money->value());
    }

    #[Test]
    public function throwsExceptionWhenComparingDifferentCurrencies(): void
    {
        $eur = new CurrencyCode('EUR');
        $moneyUsd = new Money(new Amount('10.00'), $this->usd, $this->precision);
        $moneyEur = new Money(new Amount('5.00'), $eur, $this->precision);

        $this->expectException(CurrencyMismatchException::class);

        $moneyUsd->isGreaterThan($moneyEur);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->usd = new CurrencyCode('USD');
        $this->precision = new CurrencyPrecision(2);
    }
}
