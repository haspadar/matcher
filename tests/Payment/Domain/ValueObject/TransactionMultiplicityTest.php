<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidTransactionMultiplicityException;
use Matcher\Payment\Domain\ValueObject\TransactionMultiplicity;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TransactionMultiplicityTest extends TestCase
{
    #[Test]
    public function canCreateValidTransactionMultiplicity(): void
    {
        $transactionMultiplicity = new TransactionMultiplicity(20);
        $this->assertSame(20, $transactionMultiplicity->value());
    }

    #[Test]
    public function throwsExceptionForNonMultipleOfTen(): void
    {
        $this->expectException(InvalidTransactionMultiplicityException::class);
        new TransactionMultiplicity(15);
    }

    #[Test]
    public function throwsExceptionForZero(): void
    {
        $this->expectException(InvalidTransactionMultiplicityException::class);
        new TransactionMultiplicity(0);
    }

    #[Test]
    public function allowsMultipleOfTen(): void
    {
        $transactionMultiplicity = new TransactionMultiplicity(30);
        $this->assertSame(30, $transactionMultiplicity->value());
    }
}
