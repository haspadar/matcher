<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Payment\Domain\Entity\Cashout;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Shared\Domain\ValueObject\Uuid;

/**
 * @codeCoverageIgnore
 */
interface CashoutRepositoryInterface
{
    public function save(Cashout $cashout): void;

    public function findById(Uuid $id): ?PlanningCashout;

    /**
     * @param  CashoutStatus[]  $statuses
     * @return CashoutDto[]
     */
    public function findByStatuses(array $statuses);
}
