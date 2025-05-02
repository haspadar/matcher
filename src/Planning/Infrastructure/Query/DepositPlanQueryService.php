<?php

declare(strict_types=1);

namespace Matcher\Planning\Infrastructure\Query;

use Matcher\Planning\Application\Dto\DepositAmountOptionDto;
use Matcher\Planning\Application\Query\DepositPlanQueryInterface;
use Matcher\Planning\Domain\Repository\DepositPlanRepositoryInterface;

final class DepositPlanQueryService implements DepositPlanQueryInterface
{
    public function __construct(
        private readonly DepositPlanRepositoryInterface $repository,
    ) {
    }

    #[\Override]
    /**
     * @return DepositAmountOptionDto[]
     */
    public function getAvailableDepositAmounts(string $projectId, string $currencyId): array
    {
        return $this->repository->findGroupedByAmount($projectId, $currencyId);
    }
}
