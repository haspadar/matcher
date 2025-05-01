<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Event;

use Matcher\Shared\Domain\ValueObject\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

final class CashoutCreatedEvent extends Event
{
    public function __construct(
        public readonly Uuid $cashoutId,
    ) {
    }
}
