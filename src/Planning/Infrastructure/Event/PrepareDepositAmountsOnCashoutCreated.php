<?php

declare(strict_types=1);

namespace Matcher\Planning\Infrastructure\Event;

use Matcher\Payment\Domain\Event\CashoutCreatedEvent;
use Matcher\Planning\Application\Service\BuildPreparedAmountsService;

final class PrepareDepositAmountsOnCashoutCreated
{
    public function __construct(
        private readonly BuildPreparedAmountsService $buildService,
    ) {
    }

    public function __invoke(CashoutCreatedEvent $event): void
    {
        $this->buildService->buildByCashoutId($event->cashoutId);
    }
}
