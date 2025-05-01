<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Cashout;
use Matcher\Payment\Domain\Event\CashoutCreatedEvent;
use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\Status;
use Matcher\Payment\Domain\ValueObject\Type;
use Matcher\Shared\Domain\ValueObject\PositiveAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class CashoutService
{
    public function __construct(
        private readonly CashoutRepositoryInterface $cashoutRepository,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function createCashout(
        PaymentProject $project,
        int $userId,
        CardNumber $cardNumber,
        PositiveAmount $amount,
        PaymentCurrency $currency,
        Url $callbackUrl,
        Type $type = Type::NORMAL,
    ): Cashout {
        $cashout = new Cashout(
            id: Uuid::generate(),
            project: $project,
            userId: $userId,
            cardNumber: $cardNumber,
            amount: $amount,
            currency: $currency,
            callbackUrl: $callbackUrl,
            status: Status::NEW,
            type: $type,
        );

        $this->cashoutRepository->save($cashout);

        $this->dispatcher->dispatch(
            new CashoutCreatedEvent($cashout->getId())
        );

        return $cashout;
    }
}
