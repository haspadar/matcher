<?php

declare(strict_types=1);

namespace Matcher\Planning\Application\Query;

use Matcher\Planning\Application\Dto\DepositAmountOptionDto;

interface DepositPlanQueryInterface
{
    /**
     * @return DepositAmountOptionDto[]
     */
    public function getAvailableDepositAmounts(string $projectId, string $currencyId): array;
}
