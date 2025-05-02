<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Domain\Entity\Cashout;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Shared\Domain\ValueObject\Uuid;

/**
 * @codeCoverageIgnore
 */
interface CashoutRepositoryInterface
{
    public function save(Cashout $cashout): void;

    public function findById(Uuid $id): ?PlanningCashout;
}
