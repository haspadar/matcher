<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidAmountException;
use Matcher\Shared\Domain\ValueObject\PositiveAmount;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PositiveAmountTest extends TestCase
{
    #[Test]
    public function canCreateWithPositiveAmount(): void
    {
        $amount = new PositiveAmount('100');
        $this->assertSame('100', $amount->value());
    }

    #[Test]
    public function throwsExceptionWhenZero(): void
    {
        $this->expectException(InvalidAmountException::class);

        new PositiveAmount('0');
    }

    #[Test]
    public function throwsExceptionWhenNegative(): void
    {
        $this->expectException(InvalidAmountException::class);

        new PositiveAmount('-50');
    }
}
