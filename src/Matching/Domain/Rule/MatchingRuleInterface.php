<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\Rule;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;

interface MatchingRuleInterface
{
    public function passes(MatchingDeposit $deposit, MatchingCashout $cashout): bool;
}
