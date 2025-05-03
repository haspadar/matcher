<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\Service;

use Matcher\Matching\Application\Query\PaymentQueryServiceInterface;
use Matcher\Matching\Application\Service\MatchService;
use Matcher\Matching\Domain\Event\MatchedPairEvent;
use Matcher\Matching\Domain\Service\MatchingPolicyInterface;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingCurrency;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingProject;
use Matcher\Matching\Domain\ValueObject\MatchingType;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Payment\Domain\ValueObject\DepositStatus;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class MatchServiceTest extends TestCase
{
    private MockObject $paymentQuery;
    private MockObject $policy;
    private MockObject $dispatcher;
    private MatchService $service;

    #[Test]
    public function dispatchesMatchedPairEventWhenMatchIsFound(): void
    {
        $depositId = Uuid::generate();
        $deposit = new MatchingDeposit(
            $depositId,
            new PositiveIntegerAmount(1000),
            new MatchingCurrency('USD'),
            new MatchingProject('project-1'),
            MatchingPaymentType::TEST
        );
        $cashoutId = Uuid::generate();
        $cashout = new MatchingCashout(
            $cashoutId,
            new PositiveIntegerAmount(1000),
            new MatchingCurrency('USD'),
            new MatchingProject('project-1'),
            MatchingPaymentType::TEST
        );

        $this->paymentQuery
            ->method('findDepositsByStatus')
            ->with(DepositStatus::inProgress())
            ->willReturn([$deposit]);

        $this->paymentQuery
            ->method('findCashoutsByStatus')
            ->with(CashoutStatus::inProgress())
            ->willReturn([$cashout]);

        $this->policy
            ->expects(self::once())
            ->method('isMatchable')
            ->with($deposit, $cashout)
            ->willReturn(true);

        $this->dispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::callback(function (MatchedPairEvent $event) use ($depositId, $cashoutId) {
                return $event->depositId->value() === $depositId->value()
                    && $event->cashoutId->value() === $cashoutId->value()
                    && $event->matchType === MatchingType::TEST;
            }));

        $this->service->match();
    }

    #[Test]
    public function doesNotDispatchEventIfNoMatches(): void
    {
        $deposit = new MatchingDeposit(
            Uuid::generate(),
            new PositiveIntegerAmount(1000),
            new MatchingCurrency('USD'),
            new MatchingProject('project-1'),
            MatchingPaymentType::TEST
        );

        $cashout = new MatchingCashout(
            Uuid::generate(),
            new PositiveIntegerAmount(1000),
            new MatchingCurrency('USD'),
            new MatchingProject('project-1'),
            MatchingPaymentType::TEST
        );

        $this->paymentQuery
            ->method('findDepositsByStatus')
            ->willReturn([$deposit]);

        $this->paymentQuery
            ->method('findCashoutsByStatus')
            ->willReturn([$cashout]);

        $this->policy
            ->expects(self::once())
            ->method('isMatchable')
            ->with($deposit, $cashout)
            ->willReturn(false);

        $this->dispatcher
            ->expects(self::never())
            ->method('dispatch');

        $this->service->match();
    }

    protected function setUp(): void
    {
        $this->paymentQuery = $this->createMock(PaymentQueryServiceInterface::class);
        $this->policy = $this->createMock(MatchingPolicyInterface::class);
        $this->dispatcher = $this->createMock(EventDispatcherInterface::class);

        $this->service = new MatchService(
            $this->paymentQuery,
            $this->policy,
            $this->dispatcher
        );
    }

}
