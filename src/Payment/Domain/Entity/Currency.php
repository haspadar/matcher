<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\ValueObject\AmountStep;
use Matcher\Payment\Domain\ValueObject\CurrencyCode;
use Matcher\Payment\Domain\ValueObject\CurrencyName;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;
use Matcher\Payment\Domain\ValueObject\Multiplicity;
use Matcher\Payment\Domain\ValueObject\Status;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\Uuid;

/**
 * @codeCoverageIgnore
 */
final class Currency implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private CurrencyCode $code,
        private CurrencyName $name,
        private CurrencyPrecision $precision,
        private Multiplicity $multiplicity,
        private AmountStep $amountStep,
        private Status $status,
    ) {
    }

    public function getCode(): CurrencyCode
    {
        return $this->code;
    }

    public function getName(): CurrencyName
    {
        return $this->name;
    }

    public function getPrecision(): CurrencyPrecision
    {
        return $this->precision;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getMultiplicity(): Multiplicity
    {
        return $this->multiplicity;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getAmountStep(): AmountStep
    {
        return $this->amountStep;
    }
}
