<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidBankNameException;
use Matcher\Reference\Domain\ValueObject\BankName;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class BankNameTest extends TestCase
{
    #[Test]
    public function canCreateValidBankName(): void
    {
        $bankName = new BankName('Sberbank');

        $this->assertSame('Sberbank', $bankName->value());
    }

    #[Test]
    public function throwsExceptionForInvalidCharacters(): void
    {
        $this->expectException(InvalidBankNameException::class);

        new BankName('Sber@bank');
    }

    #[Test]
    public function throwsExceptionForTooShortName(): void
    {
        $this->expectException(InvalidBankNameException::class);

        new BankName('A');
    }

    #[Test]
    public function throwsExceptionForTooLongName(): void
    {
        $this->expectException(InvalidBankNameException::class);

        new BankName(str_repeat('A', 256));
    }

    #[Test]
    public function allowsValidSpecialCharactersInName(): void
    {
        $bankName = new BankName('LLC ECOM BANK, Inc.');

        $this->assertSame('LLC ECOM BANK, Inc.', $bankName->value());
    }
}
