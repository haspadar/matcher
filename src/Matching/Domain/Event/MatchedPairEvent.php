<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\Event;

use Matcher\Matching\Domain\ValueObject\MatchingType;
use Matcher\Shared\Domain\ValueObject\Uuid;

final readonly class MatchedPairEvent
{
    public function __construct(
        public Uuid $cashoutId,
        public Uuid $depositId,
        public MatchingType $matchType,
    ) {
    }
}
