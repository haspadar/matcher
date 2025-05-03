<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\Rule;

use Matcher\Matching\Domain\Rule\SameTypeRule;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingCurrency;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingProject;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SameTypeRuleTest extends TestCase
{
    #[Test]
    public function passes_if_types_match(): void
    {
        $rule = new SameTypeRule();

        $deposit = $this->makeDeposit(MatchingPaymentType::TEST);
        $cashout = $this->makeCashout(MatchingPaymentType::TEST);

        $this->assertTrue($rule->passes($deposit, $cashout));
    }

    #[Test]
    public function fails_if_types_differ(): void
    {
        $rule = new SameTypeRule();

        $deposit = $this->makeDeposit(MatchingPaymentType::NORMAL);
        $cashout = $this->makeCashout(MatchingPaymentType::TEST);

        $this->assertFalse($rule->passes($deposit, $cashout));
    }

    private function makeDeposit(MatchingPaymentType $type): MatchingDeposit
    {
        return new MatchingDeposit(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: new MatchingCurrency('USD'),
            project: new MatchingProject('project-1'),
            type: $type
        );
    }

    private function makeCashout(MatchingPaymentType $type): MatchingCashout
    {
        return new MatchingCashout(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: new MatchingCurrency('USD'),
            project: new MatchingProject('project-1'),
            type: $type
        );
    }
}
