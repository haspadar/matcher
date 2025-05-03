<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
enum DepositStatus: string
{
    public function id(): int
    {
        return match ($this) {
            self::NEW => 11,
            self::AWAITING_PAY => 5,
            self::AWAITING_CONFIRMATION => 9,
            self::PARTIALLY_COMPLETED => 12,
        };
    }

    /** @return self[] */
    public static function inProgress(): array
    {
        return [
            self::NEW,
            self::AWAITING_PAY,
            self::AWAITING_CONFIRMATION,
            self::PARTIALLY_COMPLETED,
        ];
    }

    case NEW = 'new';
    case AWAITING_PAY = 'awaiting_pay';
    case AWAITING_CONFIRMATION = 'awaiting_confirmation';
    case PARTIALLY_COMPLETED = 'partially_completed';
}
