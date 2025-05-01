<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidAmountException;
use Matcher\Shared\Domain\ValueObject\Amount;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    #[Test]
    public function canCreateWithInteger(): void
    {
        $amount = new Amount(100);
        $this->assertSame('100', $amount->value());
    }

    #[Test]
    public function isPositiveNearZero(): void
    {
        $amount = new Amount('0.00000001');
        $this->assertTrue($amount->isPositive());
    }

    #[Test]
    public function canCreateWithNumericString(): void
    {
        $amount = new Amount('123.45');
        $this->assertSame('123.45', $amount->value());
    }

    #[Test]
    public function throwsExceptionForInvalidAmount(): void
    {
        $this->expectException(InvalidAmountException::class);

        new Amount('invalid');
    }

    #[Test]
    public function isPositive(): void
    {
        $amount = new Amount('10');
        $this->assertTrue($amount->isPositive());
        $this->assertFalse($amount->isNegative());
        $this->assertFalse($amount->isZero());
    }

    #[Test]
    public function isPositiveWithDecimal(): void
    {
        $amount = new Amount('10.5');
        $this->assertTrue($amount->isPositive());
    }

    #[Test]
    public function isNegative(): void
    {
        $amount = new Amount('-5');
        $this->assertTrue($amount->isNegative());
        $this->assertFalse($amount->isPositive());
        $this->assertFalse($amount->isZero());
    }

    #[Test]
    public function isZero(): void
    {
        $amount = new Amount('0');
        $this->assertTrue($amount->isZero());
        $this->assertFalse($amount->isPositive());
        $this->assertFalse($amount->isNegative());
    }
}
