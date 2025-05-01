<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyCodeTest extends TestCase
{
    #[Test]
    public function canCreateValidCurrencyCode(): void
    {
        $currencyCode = new CurrencyCode('usd');

        $this->assertSame('USD', $currencyCode->value());
    }

    #[Test]
    public function canCreateValidFourLetterCurrencyCode(): void
    {
        $currencyCode = new CurrencyCode('usdt');

        $this->assertSame('USDT', $currencyCode->value());
    }

    #[Test]
    public function trimCurrencyCode(): void
    {
        $currencyCode = new CurrencyCode(' USD ');

        $this->assertSame('USD', $currencyCode->value());
    }

    #[Test]
    public function canCreateValidFiveLetterCurrencyCode(): void
    {
        $currencyCode = new CurrencyCode('shiba');

        $this->assertSame('SHIBA', $currencyCode->value());
    }

    #[Test]
    #[DataProvider('invalidCurrencyCodeProvider')]
    public function throwsExceptionOnInvalidCurrencyCode(string $invalidCode): void
    {
        $this->expectException(InvalidCurrencyCodeException::class);

        new CurrencyCode($invalidCode);
    }

    /**
     * @return iterable<array{string}>
     */
    public static function invalidCurrencyCodeProvider(): iterable
    {
        return [
            ['us'],
            ['usdollar'],
            ['usd123'],
            ['123'],
            [''],
            ['u$#'],
        ];
    }

    #[Test]
    public function isEqualsReturnsTrueWhenCodesAreEqual(): void
    {
        $code1 = new CurrencyCode('usd');
        $code2 = new CurrencyCode('USD');

        $this->assertTrue($code1->isEquals($code2));
    }

    #[Test]
    public function isEqualsReturnsFalseWhenCodesAreDifferent(): void
    {
        $code1 = new CurrencyCode('usd');
        $code2 = new CurrencyCode('eur');

        $this->assertFalse($code1->isEquals($code2));
    }
}
