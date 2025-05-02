<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\Entity;

use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Planning\Domain\ValueObject\SplitType;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class PreparedDepositAmount implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private PlanningCashout $cashout,
        private int $amount,
        private SplitType $type,
        private int $priority = 0,
    ) {
        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        if ($this->priority < 1) {
            throw new \InvalidArgumentException('Priority must be at least 1');
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCashout(): PlanningCashout
    {
        return $this->cashout;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getType(): SplitType
    {
        return $this->type;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

}
