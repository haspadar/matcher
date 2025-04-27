<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCurrencyPrecisionException;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyPrecisionTest extends TestCase
{
    #[Test]
    public function canCreateValidCurrencyPrecision(): void
    {
        foreach (range(0, 18) as $validPrecision) {
            $currencyPrecision = new CurrencyPrecision($validPrecision);
            $this->assertSame($validPrecision, $currencyPrecision->value());
        }
    }

    #[Test]
    #[DataProvider('invalidPrecisionProvider')]
    public function throwsExceptionOnInvalidCurrencyPrecision(int $invalidPrecision): void
    {
        $this->expectException(InvalidCurrencyPrecisionException::class);

        new CurrencyPrecision($invalidPrecision);
    }

    /**
     * @return array<array{int}>
     */
    public static function invalidPrecisionProvider(): array
    {
        return [
            [-1],
            [-10],
            [19],
            [20],
            [999],
        ];
    }
}
