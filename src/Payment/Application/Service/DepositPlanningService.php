<?php

declare(strict_types=1);

namespace Matcher\Payment\Application\Service;

use Matcher\Planning\Application\Dto\DepositAmountOptionDto;
use Matcher\Planning\Application\Query\DepositPlanQueryInterface;

final class DepositPlanningService
{
    public function __construct(
        private readonly DepositPlanQueryInterface $query,
    ) {
    }

    /**
     * @return DepositAmountOptionDto[]
     */
    public function getAvailableDepositAmounts(string $projectId, string $currencyId): array
    {
        return $this->query->getAvailableDepositAmounts($projectId, $currencyId);
    }
}
