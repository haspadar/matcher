<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\Service;

use Matcher\Matching\Domain\Rule\MatchingRuleInterface;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;

final class RuleBasedMatchingPolicy implements MatchingPolicyInterface
{
    /**
     * @param MatchingRuleInterface[] $rules
     */
    public function __construct(
        private readonly array $rules
    ) {
    }

    #[\Override]
    public function isMatchable(MatchingDeposit $deposit, MatchingCashout $cashout): bool
    {
        foreach ($this->rules as $rule) {
            if (!$rule->passes($deposit, $cashout)) {
                return false;
            }
        }

        return true;
    }
}
