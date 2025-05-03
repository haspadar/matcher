<?php

declare(strict_types=1);

namespace Matcher\Planning\Application\Service;

use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Planning\Domain\Entity\PreparedDepositAmount;
use Matcher\Planning\Domain\Repository\PreparedAmountRepositoryInterface;
use Matcher\Planning\Domain\ValueObject\PlanningCashout;
use Matcher\Planning\Domain\ValueObject\SplitType;
use Matcher\Planning\Infrastructure\Exception\CashoutNotFoundException;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class BuildPreparedAmountsService implements BuildPreparedAmountsServiceInterface
{
    public function __construct(
        private readonly PreparedAmountRepositoryInterface $repository,
        private readonly CashoutRepositoryInterface $cashoutRepository,
    ) {
    }

    #[\Override]
    public function buildByCashoutId(Uuid $cashoutId): void
    {
        $cashout = $this->cashoutRepository->findById($cashoutId);
        if ($cashout === null) {
            throw new CashoutNotFoundException($cashoutId);
        }

        $preparedAmounts = $this->calculate($cashout);

        $this->repository->saveMany($preparedAmounts);
    }

    /**
     * Остаток от деления - в remain, остальное - в main
     *
     * @return PreparedDepositAmount[]
     */
    private function calculate(PlanningCashout $cashout): array
    {
        $step = 1000;
        $total = $cashout->amount->value();

        $fullParts = intdiv($total, $step);
        $remainder = $total % $step;

        $preparedAmounts = [];

        for ($i = 0; $i < $fullParts; $i++) {
            $preparedAmounts[] = new PreparedDepositAmount(
                id: Uuid::generate(),
                cashout: $cashout,
                amount: $step,
                type: SplitType::MAIN,
                priority: $i + 1,
            );
        }

        if ($remainder > 0) {
            $preparedAmounts[] = new PreparedDepositAmount(
                id: Uuid::generate(),
                cashout: $cashout,
                amount: $remainder,
                type: SplitType::REMAIN,
                priority: $fullParts + 1,
            );
        }

        return $preparedAmounts;
    }
}
