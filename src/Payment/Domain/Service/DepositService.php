<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use function in_array;

use Matcher\Payment\Domain\Entity\Deposit;
use Matcher\Payment\Domain\Event\DepositCreatedEvent;
use Matcher\Payment\Domain\Exception\InvalidDepositAmount;
use Matcher\Payment\Domain\Repository\DepositRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\DepositStatus;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\Type;
use Matcher\Planning\Application\Query\DepositPlanQueryInterface;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class DepositService
{
    public function __construct(
        private readonly DepositRepositoryInterface $depositRepository,
        private readonly DepositPlanQueryInterface $planQuery,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function createDeposit(
        PaymentProject $project,
        int $userId,
        CardNumber $cardNumber,
        PositiveIntegerAmount $amount,
        PaymentCurrency $currency,
        Url $callbackUrl,
        Type $type = Type::NORMAL,
    ): Deposit {
        $this->validateAmount($amount, $project, $currency);

        $deposit = new Deposit(
            id: Uuid::generate(),
            project: $project,
            userId: $userId,
            cardNumber: $cardNumber,
            amount: $amount,
            currency: $currency,
            callbackUrl: $callbackUrl,
            status: DepositStatus::NEW,
            type: $type,
        );

        $this->depositRepository->save($deposit);

        $this->dispatcher->dispatch(
            new DepositCreatedEvent($deposit->getId())
        );

        return $deposit;
    }

    private function validateAmount(PositiveIntegerAmount $amount, PaymentProject $project, PaymentCurrency $currency): void
    {
        $available = $this->planQuery->getAvailableDepositAmounts($project->code, $currency->code);

        if (!in_array(
            $amount->value(),
            array_map(fn ($dto) => $dto->amount, $available),
            true
        )) {
            throw new InvalidDepositAmount('Amount is not allowed by deposit plan');
        }
    }

}
