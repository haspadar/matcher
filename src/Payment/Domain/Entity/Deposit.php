<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\Exception\InvalidUserIdException;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\DepositStatus;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\Type;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Deposit implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private PaymentProject $project,
        private int $userId,
        private CardNumber $cardNumber,
        private PositiveIntegerAmount $amount,
        private PaymentCurrency $currency,
        private Url $callbackUrl,
        private DepositStatus $status,
        private Type $type,
    ) {
        $this->validateUserId($userId);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProject(): PaymentProject
    {
        return $this->project;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCardNumber(): CardNumber
    {
        return $this->cardNumber;
    }

    public function getAmount(): PositiveIntegerAmount
    {
        return $this->amount;
    }

    public function getCurrency(): PaymentCurrency
    {
        return $this->currency;
    }

    public function getCallbackUrl(): Url
    {
        return $this->callbackUrl;
    }

    public function getStatus(): DepositStatus
    {
        return $this->status;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    private function validateUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new InvalidUserIdException('User ID must be positive');
        }
    }
}
