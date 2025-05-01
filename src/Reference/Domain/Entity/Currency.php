<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Entity;

use Matcher\Reference\Domain\ValueObject\AmountStep;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Currency implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private CurrencyCode $code,
        private CurrencyName $name,
        private CurrencyPrecision $precision,
        private Multiplicity $multiplicity,
        private AmountStep $amountStep,
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

    public function getAmountStep(): AmountStep
    {
        return $this->amountStep;
    }
}
