<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\ValueObject\CurrencyCode;
use Matcher\Payment\Domain\ValueObject\CurrencyName;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;
use Matcher\Shared\Domain\Entity\EntityInterface;

/**
 * @codeCoverageIgnore
 */
final class Currency implements EntityInterface
{
    public function __construct(
        private CurrencyCode $code,
        private CurrencyName $name,
        private CurrencyPrecision $precision,
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

}
