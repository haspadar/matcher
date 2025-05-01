<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidPositiveAmountException;
use Matcher\Shared\Domain\Exception\InvalidPositiveIntegerAmountException;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PositiveIntegerAmountTest extends TestCase
{
    #[Test]
    public function canCreateWithValidInteger(): void
    {
        $amount = new PositiveIntegerAmount(100);
        $this->assertSame(100, $amount->value());
    }

    #[Test]
    public function canCreateWithIntegerString(): void
    {
        $amount = new PositiveIntegerAmount('42');
        $this->assertSame(42, $amount->value());
    }

    #[Test]
    public function allowsTrailingZeros(): void
    {
        $amount = new PositiveIntegerAmount('123.000');
        $this->assertSame(123, $amount->value());
    }

    #[Test]
    public function throwsExceptionWhenNotInteger(): void
    {
        $this->expectException(InvalidPositiveIntegerAmountException::class);
        new PositiveIntegerAmount('12.34');
    }

    #[Test]
    public function throwsExceptionWhenZero(): void
    {
        $this->expectException(InvalidPositiveAmountException::class);
        new PositiveIntegerAmount(0);
    }

    #[Test]
    public function throwsExceptionWhenNegative(): void
    {
        $this->expectException(InvalidPositiveAmountException::class);
        new PositiveIntegerAmount(-5);
    }
}
