<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Entity;

use Matcher\Payment\Domain\Entity\Bank;
use Matcher\Payment\Domain\ValueObject\BankName;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    #[Test]
    public function equalsReturnsTrueForSameId(): void
    {
        $uuid = Uuid::generate();
        $bank1 = new Bank($uuid, new BankName('Sberbank'));
        $bank2 = new Bank($uuid, new BankName('Sberbank'));

        $this->assertTrue($bank1->equals($bank2));
    }

    #[Test]
    public function equalsReturnsFalseForDifferentId(): void
    {
        $uuid1 = Uuid::generate();
        $uuid2 = Uuid::generate();
        $bank1 = new Bank($uuid1, new BankName('Sberbank'));
        $bank2 = new Bank($uuid2, new BankName('Tinkoff'));

        $this->assertFalse($bank1->equals($bank2));
    }

    #[Test]
    public function getIdReturnsCorrectUuid(): void
    {
        $uuid = Uuid::generate();
        $bank = new Bank($uuid, new BankName('Sberbank'));

        $this->assertSame($uuid->value(), $bank->getId()->value());
    }

    #[Test]
    public function getNameReturnsCorrectName(): void
    {
        $bankName = new BankName('Sberbank');
        $bank = new Bank(Uuid::generate(), $bankName);

        $this->assertSame($bankName->value(), $bank->getName()->value());
    }
}
