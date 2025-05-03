<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\Service;

use Matcher\Matching\Domain\Rule\MatchingRuleInterface;
use Matcher\Matching\Domain\Service\RuleBasedMatchingPolicy;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingCurrency;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingProject;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RuleBasedMatchingPolicyTest extends TestCase
{
    private MatchingDeposit $deposit;
    private MatchingCashout $cashout;

    #[Test]
    public function returnsTrueIfAllRulesPass(): void
    {
        $policy = new RuleBasedMatchingPolicy([
            $this->passingRule(),
            $this->passingRule(),
        ]);

        $this->assertTrue($policy->isMatchable($this->deposit, $this->cashout));
    }

    #[Test]
    public function returnsFalseIfAnyRuleFails(): void
    {
        $policy = new RuleBasedMatchingPolicy([
            $this->passingRule(),
            $this->failingRule(),
        ]);

        $this->assertFalse($policy->isMatchable($this->deposit, $this->cashout));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $currency = new MatchingCurrency('USD');
        $project = new MatchingProject('test-project');

        $this->deposit = new MatchingDeposit(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: $currency,
            project: $project,
            type: MatchingPaymentType::NORMAL
        );

        $this->cashout = new MatchingCashout(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: $currency,
            project: $project,
            type: MatchingPaymentType::NORMAL
        );
    }

    private function passingRule(): MatchingRuleInterface
    {
        $rule = $this->createMock(MatchingRuleInterface::class);
        $rule->method('passes')->willReturn(true);
        return $rule;
    }

    private function failingRule(): MatchingRuleInterface
    {
        $rule = $this->createMock(MatchingRuleInterface::class);
        $rule->method('passes')->willReturn(false);
        return $rule;
    }
}
