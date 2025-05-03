<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\Service;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;

interface MatchingPolicyInterface
{
    public function isMatchable(MatchingDeposit $deposit, MatchingCashout $cashout): bool;
}
