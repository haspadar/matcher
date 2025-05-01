<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

final readonly class PaymentProject
{
    public function __construct(
        public string $code,
        public bool $isActive,
    ) {
    }
}
