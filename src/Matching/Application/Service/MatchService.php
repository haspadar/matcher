<?php

declare(strict_types=1);

namespace Matcher\Matching\Application\Service;

use Matcher\Matching\Application\Query\PaymentQueryServiceInterface;
use Matcher\Matching\Domain\Event\MatchedPairEvent;
use Matcher\Matching\Domain\Service\MatchingPolicyInterface;
use Matcher\Matching\Domain\ValueObject\MatchingType;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Payment\Domain\ValueObject\DepositStatus;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class MatchService
{
    public function __construct(
        private PaymentQueryServiceInterface $paymentQueryService,
        private MatchingPolicyInterface $policy,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function match(): void
    {
        $deposits = $this->paymentQueryService->findDepositsByStatus(
            DepositStatus::inProgress()
        );

        $cashouts = $this->paymentQueryService->findCashoutsByStatus(
            CashoutStatus::inProgress()
        );

        foreach ($deposits as $deposit) {
            foreach ($cashouts as $cashout) {
                if (!$this->policy->isMatchable($deposit, $cashout)) {
                    continue;
                }

                $this->dispatcher->dispatch(
                    new MatchedPairEvent(
                        $cashout->id,
                        $deposit->id,
                        MatchingType::fromPaymentType($deposit->type, $cashout->type),
                    )
                );
                break;
            }
        }
    }
}
