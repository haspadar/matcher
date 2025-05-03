<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\Rule;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;

final class SameCurrencyRule implements MatchingRuleInterface
{
    #[\Override]
    public function passes(MatchingDeposit $deposit, MatchingCashout $cashout): bool
    {
        return $deposit->currency->code === $cashout->currency->code;
    }
}
