<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidBankNameException;
use Matcher\Payment\Domain\ValueObject\BankName;
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
        $this->expectExceptionMessage('Bank name must contain only Latin letters, spaces, commas, periods, or dashes.');

        new BankName('Sber@bank');
    }

    #[Test]
    public function throwsExceptionForTooShortName(): void
    {
        $this->expectException(InvalidBankNameException::class);
        $this->expectExceptionMessage('Bank name must be between 2 and 255 characters.');

        new BankName('A'); // слишком короткое имя
    }

    #[Test]
    public function throwsExceptionForTooLongName(): void
    {
        $this->expectException(InvalidBankNameException::class);
        $this->expectExceptionMessage('Bank name must be between 2 and 255 characters.');

        new BankName(str_repeat('A', 256)); // слишком длинное имя
    }

    #[Test]
    public function allowsValidSpecialCharactersInName(): void
    {
        $bankName = new BankName('LLC ECOM BANK, Inc.');

        $this->assertSame('LLC ECOM BANK, Inc.', $bankName->value());
    }
}
