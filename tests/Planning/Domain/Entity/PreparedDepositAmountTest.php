<?php

declare(strict_types=1);

namespace Matcher\Tests\Planning\Domain\Entity;

use Matcher\Planning\Domain\Entity\PreparedDepositAmount;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;
use Matcher\Planning\Domain\ValueObject\PlanningProject;
use Matcher\Planning\Domain\ValueObject\SplitType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PreparedDepositAmountTest extends TestCase
{
    #[Test]
    public function createsValidPreparedDepositAmount(): void
    {
        $id = Uuid::generate();
        $cashoutId = Uuid::generate();

        $currency = new PlanningCurrency('USD');
        $project = new PlanningProject('ProjectX');
        $amount = new PositiveIntegerAmount(100);
        $preparedAmount = new PreparedDepositAmount(
            id: $id,
            cashout: new PlanningCashout(
                $cashoutId,
                $amount,
                $currency,
                $project,
            ),
            amount: 1000,
            type: SplitType::MAIN,
            priority: 1
        );

        $this->assertSame(1000, $preparedAmount->getAmount());
        $this->assertSame(1, $preparedAmount->getPriority());
        $this->assertSame(SplitType::MAIN, $preparedAmount->getType());
        $this->assertSame($id, $preparedAmount->getId());
        $this->assertSame($cashoutId, $preparedAmount->getCashout()->id);
    }

    #[Test]
    public function throwsExceptionForNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be positive');

        new PreparedDepositAmount(
            id: Uuid::generate(),
            cashout: new PlanningCashout(
                Uuid::generate(),
                new PositiveIntegerAmount(100),
                new PlanningCurrency('USD'),
                new PlanningProject('ProjectX'),
            ),
            amount: 0,
            type: SplitType::MAIN,
            priority: 1
        );
    }

    #[Test]
    public function throwsExceptionForZeroPriority(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Priority must be at least 1');

        new PreparedDepositAmount(
            id: Uuid::generate(),
            cashout: new PlanningCashout(
                Uuid::generate(),
                new PositiveIntegerAmount(100),
                new PlanningCurrency('USD'),
                new PlanningProject('ProjectX'),
            ),
            amount: 100,
            type: SplitType::MAIN,
            priority: 0
        );
    }

}
