<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Deposit;
use Matcher\Payment\Domain\Event\DepositCreatedEvent;
use Matcher\Payment\Domain\Exception\InvalidDepositAmount;
use Matcher\Payment\Domain\Repository\DepositRepositoryInterface;
use Matcher\Payment\Domain\Service\DepositService;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Planning\Application\Dto\DepositAmountOptionDto;
use Matcher\Planning\Application\Query\DepositPlanQueryInterface;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class DepositServiceTest extends TestCase
{
    private MockObject $depositRepository;
    private MockObject $eventDispatcher;
    private MockObject $planQuery;
    private DepositService $depositService;

    #[Test]
    public function canCreateValidDeposit(): void
    {
        $userId = 123;
        $cardNumber = new CardNumber('1234567890123456');
        $amount = new PositiveIntegerAmount(1000);
        $currency = new PaymentCurrency('USD', 100);
        $callbackUrl = new Url('https://example.com/callback');
        $type = PaymentType::TEST;
        $project = new PaymentProject('some-project-code', true);

        $this->planQuery
            ->expects(self::once())
            ->method('getAvailableDepositAmounts')
            ->with($project->code, $currency->code)
            ->willReturn([
                new DepositAmountOptionDto(1000, 2),
                new DepositAmountOptionDto(2000, 1),
            ]);

        $this->depositRepository
            ->expects(self::once())
            ->method('save')
            ->with(
                self::callback(
                    fn (Deposit $deposit)
                        => $deposit->getUserId() === $userId &&
                        $deposit->getCardNumber()->value() === $cardNumber->value() &&
                        $deposit->getProject()->code === $project->code &&
                        $deposit->getAmount()->value() === $amount->value() &&
                        $deposit->getCurrency()->code === $currency->code &&
                        $deposit->getCallbackUrl()->value() === $callbackUrl->value() &&
                        $deposit->getType() === $type,
                ),
            );

        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(DepositCreatedEvent::class));

        $deposit = $this->depositService->createDeposit(
            $project,
            $userId,
            $cardNumber,
            $amount,
            $currency,
            $callbackUrl,
            $type,
        );

        $this->assertInstanceOf(Deposit::class, $deposit);
    }

    #[Test]
    public function throwsExceptionForInvalidAmount(): void
    {
        $this->expectException(InvalidDepositAmount::class);

        $project = new PaymentProject('some-project-code', true);
        $currency = new PaymentCurrency('USD', 100);
        $amount = new PositiveIntegerAmount(999);

        $this->planQuery
            ->method('getAvailableDepositAmounts')
            ->willReturn([
                new DepositAmountOptionDto(1000, 2),
                new DepositAmountOptionDto(2000, 1),
            ]);

        $this->depositService->createDeposit(
            $project,
            123,
            new CardNumber('1234567890123456'),
            $amount,
            $currency,
            new Url('https://example.com/callback'),
            PaymentType::NORMAL,
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->depositRepository = $this->createMock(DepositRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->planQuery = $this->createMock(DepositPlanQueryInterface::class);

        $this->depositService = new DepositService(
            $this->depositRepository,
            $this->planQuery,
            $this->eventDispatcher,
        );
    }
}
