<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\ValueObject;

use Matcher\Payment\Domain\ValueObject\PaymentType;

enum MatchingPaymentType: string
{
    public static function fromPaymentType(PaymentType $type): self
    {
        return match ($type) {
            PaymentType::NORMAL => self::NORMAL,
            PaymentType::TEST => self::TEST,
        };
    }
    case NORMAL = 'normal';
    case TEST = 'test';
}
