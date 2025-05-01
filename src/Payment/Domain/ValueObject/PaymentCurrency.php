<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

final readonly class PaymentCurrency
{
    public function __construct(
        public string $code,
        public int $amountStep,
    ) {
    }
}
