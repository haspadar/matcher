<?php

declare(strict_types=1);

namespace Matcher\Planning\Application\Service;

use Matcher\Planning\Domain\Repository\PreparedAmountRepositoryInterface;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;

final class RebuildPreparedAmountsService
{
    public function __construct(
        private readonly PreparedAmountRepositoryInterface $preparedRepository,
        private readonly BuildPreparedAmountsServiceInterface $buildService,
    ) {
    }

    public function rebuildByCurrency(PlanningCurrency $currency): void
    {
        $cashoutIds = $this->preparedRepository->findNotPreparedCashoutIds($currency);
        foreach ($cashoutIds as $cashoutId) {
            $this->preparedRepository->deleteByCashoutId($cashoutId);
            $this->buildService->buildByCashoutId($cashoutId);
        }
    }
}
