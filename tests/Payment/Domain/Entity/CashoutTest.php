<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Entity;

use Matcher\Payment\Domain\Entity\Cashout;
use Matcher\Payment\Domain\Exception\InvalidUserIdException;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Reference\Domain\Exception\InvalidAmountStepException;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CashoutTest extends TestCase
{
    #[Test]
    public function throwsExceptionForNonMultipleOfAmountStep(): void
    {
        $this->expectException(InvalidAmountStepException::class);

        new Cashout(
            Uuid::generate(),
            new PaymentProject('some-project-code', true),
            123,
            new CardNumber('1234567890123456'),
            new PositiveIntegerAmount(150),
            new PaymentCurrency('USD', 100),
            new Url('http://callback.url'),
            CashoutStatus::NEW,
            PaymentType::NORMAL,
        );
    }

    #[Test]
    public function throwsExceptionForInvalidUserId(): void
    {
        $this->expectException(InvalidUserIdException::class);

        new Cashout(
            Uuid::generate(),
            new PaymentProject('some-project-code', true),
            0,
            new CardNumber('1234567890123456'),
            new PositiveIntegerAmount(150),
            new PaymentCurrency('USD', 100),
            new Url('http://callback.url'),
            CashoutStatus::NEW,
            PaymentType::NORMAL,
        );
    }

    #[Test]
    public function canCreateValidCashout(): void
    {
        $id = Uuid::generate();
        $projectCode = 'some-project-code';
        $userId = 123;
        $cardNumber = new CardNumber('1234567890123456');
        $amount = new PositiveIntegerAmount(300);
        $currency = new PaymentCurrency('USD', 100);
        $callbackUrl = new Url('http://callback.url');
        $status = CashoutStatus::NEW;
        $type = PaymentType::TEST;

        $cashout = new Cashout(
            $id,
            new PaymentProject($projectCode, true),
            $userId,
            $cardNumber,
            $amount,
            $currency,
            $callbackUrl,
            $status,
            $type
        );

        $this->assertSame($id, $cashout->getId());
        $this->assertSame($userId, $cashout->getUserId());
        $this->assertSame($cardNumber->value(), $cashout->getCardNumber()->value());
        $this->assertSame($amount->value(), $cashout->getAmount()->value());
        $this->assertSame($currency->code, $cashout->getCurrency()->code);
        $this->assertSame($callbackUrl->value(), $cashout->getCallbackUrl()->value());
        $this->assertSame($status, $cashout->getStatus());
        $this->assertSame($type, $cashout->getType());
    }

}
