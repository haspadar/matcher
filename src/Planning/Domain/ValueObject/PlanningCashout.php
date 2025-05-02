<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\ValueObject;

use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;

final readonly class PlanningCashout
{
    public function __construct(
        public Uuid $id,
        public PositiveIntegerAmount $amount,
        public PlanningCurrency $currency,
        public PlanningProject $project,
    ) {

    }
}
