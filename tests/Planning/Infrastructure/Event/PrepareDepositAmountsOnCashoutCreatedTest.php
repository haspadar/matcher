<?php

declare(strict_types=1);

namespace Matcher\Tests\Planning\Infrastructure\Event;

use Matcher\Payment\Domain\Event\CashoutCreatedEvent;
use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Planning\Application\Service\BuildPreparedAmountsService;
use Matcher\Planning\Domain\Entity\PreparedDepositAmount;
use Matcher\Planning\Domain\Repository\PreparedAmountRepositoryInterface;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;
use Matcher\Planning\Domain\ValueObject\PlanningProject;
use Matcher\Planning\Infrastructure\Event\PrepareDepositAmountsOnCashoutCreated;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PrepareDepositAmountsOnCashoutCreatedTest extends TestCase
{
    private MockObject $repository;
    private MockObject $cashoutRepository;
    private PrepareDepositAmountsOnCashoutCreated $listener;

    #[Test]
    public function createsPreparedAmountsFromCashout(): void
    {
        $cashoutId = Uuid::generate();
        $cashout = new PlanningCashout(
            id: $cashoutId,
            amount: new PositiveIntegerAmount(2500),
            currency: new PlanningCurrency('USD'),
            project: new PlanningProject('project-x'),
        );

        $this->cashoutRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cashoutId)
            ->willReturn($cashout);

        $callback =
            function (array $amounts): bool {
                assert($amounts[0] instanceof PreparedDepositAmount);
                assert($amounts[1] instanceof PreparedDepositAmount);
                assert($amounts[2] instanceof PreparedDepositAmount);

                return count($amounts) === 3
                    && $amounts[0]->getAmount() === 1000
                    && $amounts[0]->getPriority() === 1
                    && $amounts[1]->getAmount() === 1000
                    && $amounts[1]->getPriority() === 2
                    && $amounts[2]->getAmount() === 500
                    && $amounts[2]->getPriority() === 3;
            };

        $this->repository
            ->expects(self::once())
            ->method('saveMany')
            ->with(self::callback($callback));

        ($this->listener)(new CashoutCreatedEvent($cashoutId));
    }

    #[Test]
    public function throwsExceptionIfCashoutNotFound(): void
    {
        $missingId = Uuid::generate();

        $this->cashoutRepository
            ->expects(self::once())
            ->method('findById')
            ->with($missingId)
            ->willReturn(null);

        $this->expectException(\Matcher\Planning\Infrastructure\Exception\CashoutNotFoundException::class);
        $this->expectExceptionMessage($missingId->value());

        ($this->listener)(new CashoutCreatedEvent($missingId));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PreparedAmountRepositoryInterface::class);
        $this->cashoutRepository = $this->createMock(CashoutRepositoryInterface::class);

        $builder = new BuildPreparedAmountsService(
            repository: $this->repository,
            cashoutRepository: $this->cashoutRepository,
        );

        $this->listener = new PrepareDepositAmountsOnCashoutCreated($builder);
    }
}
