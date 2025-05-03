<?php

declare(strict_types=1);

namespace Matcher\Payment\Application\Dto;

use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;

final readonly class CashoutDto
{
    public function __construct(
        public Uuid $id,
        public PositiveIntegerAmount $amount,
        public string $currencyCode,
        public string $projectCode,
        public PaymentType $type,
    ) {}
}
