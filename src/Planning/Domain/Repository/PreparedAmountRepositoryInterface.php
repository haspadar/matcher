<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\Repository;

use Matcher\Planning\Domain\Entity\PreparedDepositAmount;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;
use Matcher\Shared\Domain\ValueObject\Uuid;

interface PreparedAmountRepositoryInterface
{
    public function save(PreparedDepositAmount $preparedAmount): void;

    /**
     * @param PreparedDepositAmount[] $amounts
     */
    public function saveMany(array $amounts): void;

    public function deleteByCashoutId(Uuid $cashoutId): void;

    /**
     * @return Uuid[]
     */
    public function findNotPreparedCashoutIds(PlanningCurrency $currency): array;
}
