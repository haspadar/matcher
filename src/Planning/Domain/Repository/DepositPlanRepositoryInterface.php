<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\Repository;

use Matcher\Planning\Application\Dto\DepositAmountOptionDto;

interface DepositPlanRepositoryInterface
{
    /**
     * @return DepositAmountOptionDto[]
     */
    public function findGroupedByAmount(string $projectId, string $currencyId): array;
}
