<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\ValueObject;

enum MatchingType: string
{
    public static function fromPaymentType(MatchingPaymentType $deposit, MatchingPaymentType $cashout): self
    {
        if ($deposit === $cashout) {
            return match ($deposit) {
                MatchingPaymentType::NORMAL => self::NORMAL,
                MatchingPaymentType::TEST => self::TEST,
            };
        }

        return self::TEST;
    }

    case NORMAL = 'normal';
    case TEST = 'test';
}
