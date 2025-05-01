<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
enum Status: string
{
    public function id(): int
    {
        return match ($this) {
            self::NEW => 1,
        };
    }

    case NEW = 'new';
}
