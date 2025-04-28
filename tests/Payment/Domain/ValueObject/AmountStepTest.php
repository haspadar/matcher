<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidAmountStepException;
use Matcher\Payment\Domain\ValueObject\AmountStep;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AmountStepTest extends TestCase
{
    #[Test]
    public function canCreateValidAmountStep(): void
    {
        $amountStep = new AmountStep(200);
        $this->assertSame(200, $amountStep->value());
    }

    #[Test]
    public function throwsExceptionForNonMultipleOfHundred(): void
    {
        $this->expectException(InvalidAmountStepException::class);
        new AmountStep(150); // Проверка на кратность 100
    }

    #[Test]
    public function throwsExceptionForZero(): void
    {
        $this->expectException(InvalidAmountStepException::class);
        new AmountStep(0); // Проверка на 0
    }

    #[Test]
    public function allowsMultipleOfHundred(): void
    {
        $amountStep = new AmountStep(300);
        $this->assertSame(300, $amountStep->value()); // Проверка на кратность 100
    }
}
