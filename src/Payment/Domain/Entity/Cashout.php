<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\Exception\InvalidUserIdException;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\CashoutStatus;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Reference\Domain\Exception\InvalidAmountStepException;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Cashout implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private PaymentProject $project,
        private int $userId,
        private CardNumber $cardNumber,
        private PositiveIntegerAmount $amount,
        private PaymentCurrency $currency,
        private Url $callbackUrl,
        private CashoutStatus $status,
        private PaymentType $type,
    ) {
        $this->validateUserId($userId);
        $this->validateAmount($amount, $currency);
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

    public function getStatus(): CashoutStatus
    {
        return $this->status;
    }

    public function getType(): PaymentType
    {
        return $this->type;
    }

    private function validateAmount(PositiveIntegerAmount $amount, PaymentCurrency $currency): void
    {
        $amountStep = $currency->amountStep;
        if ($amount->value() % $amountStep !== 0) {
            throw new InvalidAmountStepException(
                sprintf('Amount must be a multiple of %d', $amountStep),
            );
        }
    }

    private function validateUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new InvalidUserIdException('User ID must be positive');
        }
    }
}
