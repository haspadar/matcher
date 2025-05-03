<?php

declare(strict_types=1);

namespace Matcher\Matching\Application\Query;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Payment\Application\Dto\DepositDto;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Payment\Domain\ValueObject\DepositStatus;

interface PaymentQueryServiceInterface
{
    /**
     * @param DepositStatus[] $statuses
     * @return MatchingDeposit[]
     */
    public function findDepositsByStatus(array $statuses): array;

    /**
     * @param CashoutStatus[] $statuses
     * @return MatchingCashout[]
     */
    public function findCashoutsByStatus(array $statuses): array;
}
