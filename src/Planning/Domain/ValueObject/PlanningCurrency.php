<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\ValueObject;

final readonly class PlanningCurrency
{
    public function __construct(public string $code)
    {
    }
}
