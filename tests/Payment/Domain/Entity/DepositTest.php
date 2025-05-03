<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Entity;

use Matcher\Payment\Domain\Entity\Deposit;
use Matcher\Payment\Domain\Exception\InvalidUserIdException;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\DepositStatus;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DepositTest extends TestCase
{
    #[Test]
    public function throwsExceptionForInvalidUserId(): void
    {
        $this->expectException(InvalidUserIdException::class);

        new Deposit(
            Uuid::generate(),
            new PaymentProject('project-code', true),
            0,
            new CardNumber('1234567890123456'),
            new PositiveIntegerAmount(100),
            new PaymentCurrency('USD', 100),
            new Url('https://callback.url'),
            DepositStatus::NEW,
            PaymentType::NORMAL,
        );
    }

    #[Test]
    public function canCreateValidDeposit(): void
    {
        $id = Uuid::generate();
        $userId = 123;
        $amount = new PositiveIntegerAmount(300);
        $currency = new PaymentCurrency('USD', 100);
        $project = new PaymentProject('project-code', true);
        $cardNumber = new CardNumber('1234567890123456');
        $callbackUrl = new Url('https://callback.url');
        $status = DepositStatus::NEW;
        $type = PaymentType::TEST;

        $deposit = new Deposit(
            $id,
            $project,
            $userId,
            $cardNumber,
            $amount,
            $currency,
            $callbackUrl,
            $status,
            $type
        );

        $this->assertSame($id, $deposit->getId());
        $this->assertSame($userId, $deposit->getUserId());
        $this->assertSame($amount->value(), $deposit->getAmount()->value());
        $this->assertSame($currency->code, $deposit->getCurrency()->code);
        $this->assertSame($cardNumber->value(), $deposit->getCardNumber()->value());
        $this->assertSame($callbackUrl->value(), $deposit->getCallbackUrl()->value());
        $this->assertSame($status, $deposit->getStatus());
        $this->assertSame($type, $deposit->getType());
    }
}
