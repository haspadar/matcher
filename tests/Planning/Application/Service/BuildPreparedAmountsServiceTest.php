<?php

declare(strict_types=1);

namespace Matcher\Tests\Planning\Application\Service;

use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Planning\Application\Service\BuildPreparedAmountsService;
use Matcher\Planning\Domain\Entity\PreparedDepositAmount;
use Matcher\Planning\Domain\Repository\PreparedAmountRepositoryInterface;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;
use Matcher\Planning\Domain\ValueObject\PlanningProject;
use Matcher\Planning\Domain\ValueObject\SplitType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class BuildPreparedAmountsServiceTest extends TestCase
{
    private MockObject $repository;
    private MockObject $cashoutRepository;
    private BuildPreparedAmountsService $service;

    #[Test]
    public function buildsPreparedAmountsForCashout(): void
    {
        $cashoutId = Uuid::generate();
        $amount = new PositiveIntegerAmount(2500);
        $currency = new PlanningCurrency('USD');
        $project = new PlanningProject('Project A');

        $cashout = new PlanningCashout($cashoutId, $amount, $currency, $project);

        $this->cashoutRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cashoutId)
            ->willReturn($cashout);

        $this->repository
            ->expects(self::once())
            ->method('saveMany')
            ->with(self::callback(function (array $items) use ($cashout): bool {
                if (count($items) !== 3) {
                    return false;
                }

                [$first, $second, $third] = $items;

                return $first instanceof PreparedDepositAmount
                    && $second instanceof PreparedDepositAmount
                    && $third instanceof PreparedDepositAmount
                    && $first->getAmount() === 1000
                    && $first->getType() === SplitType::MAIN
                    && $second->getAmount() === 1000
                    && $second->getType() === SplitType::MAIN
                    && $third->getAmount() === 500
                    && $third->getType() === SplitType::REMAIN
                    && $first->getCashout() === $cashout;
            }));

        $this->service->buildByCashoutId($cashoutId);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PreparedAmountRepositoryInterface::class);
        $this->cashoutRepository = $this->createMock(CashoutRepositoryInterface::class);
        $this->service = new BuildPreparedAmountsService($this->repository, $this->cashoutRepository);
    }
}
