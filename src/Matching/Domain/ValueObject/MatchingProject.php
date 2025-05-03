<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\ValueObject;

final readonly class MatchingProject
{
    public function __construct(
        public string $code,
    ) {
    }
}
