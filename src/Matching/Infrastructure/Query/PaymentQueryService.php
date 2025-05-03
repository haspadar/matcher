<?php

declare(strict_types=1);

namespace Matcher\Matching\Infrastructure\Query;

use Matcher\Matching\Application\Query\PaymentQueryServiceInterface;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingCurrency;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingProject;
use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Payment\Application\Dto\DepositDto;
use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Payment\Domain\Repository\DepositRepositoryInterface;

final class PaymentQueryService implements PaymentQueryServiceInterface
{
    public function __construct(
        private readonly DepositRepositoryInterface $depositRepository,
        private readonly CashoutRepositoryInterface $cashoutRepository,
    ) {
    }

    #[\Override]
    public function findDepositsByStatus(array $statuses): array
    {
        $deposits = $this->depositRepository->findByStatuses($statuses);

        return array_map(
            fn (DepositDto $deposit) => new MatchingDeposit(
                id: $deposit->id,
                amount: $deposit->amount,
                currency: new MatchingCurrency($deposit->currencyCode),
                project: new MatchingProject(code: $deposit->projectCode),
                type: MatchingPaymentType::fromPaymentType($deposit->type),
            ),
            $deposits
        );
    }

    #[\Override]
    public function findCashoutsByStatus(array $statuses): array
    {
        $cashouts = $this->cashoutRepository->findByStatuses($statuses);

        return array_map(
            fn (CashoutDto $cashout) => new MatchingCashout(
                id: $cashout->id,
                amount: $cashout->amount,
                currency: new MatchingCurrency($cashout->currencyCode),
                project: new MatchingProject(code: $cashout->projectCode),
                type: MatchingPaymentType::fromPaymentType($cashout->type),
            ),
            $cashouts
        );
    }
}
