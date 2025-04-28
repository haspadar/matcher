<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\UserId;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\PositiveAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Cashout implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private Project $project,
        private UserId $userId,
        private CardNumber $cardNumber,
        private PositiveAmount $amount,
        private Currency $currency,
        private Url $callbackUrl,
        private bool $isTest,
    ) {

    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCardNumber(): CardNumber
    {
        return $this->cardNumber;
    }

    public function getAmount(): PositiveAmount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getCallbackUrl(): Url
    {
        return $this->callbackUrl;
    }

    public function isTest(): bool
    {
        return $this->isTest;
    }

}
