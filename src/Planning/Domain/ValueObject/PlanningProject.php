<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\ValueObject;

final readonly class PlanningProject
{
    public function __construct(
        public string $code,
    ) {
    }
}
