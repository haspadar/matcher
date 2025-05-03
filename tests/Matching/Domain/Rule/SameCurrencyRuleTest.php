<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\Rule;

use Matcher\Matching\Domain\Rule\SameCurrencyRule;
use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingCurrency;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingProject;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SameCurrencyRuleTest extends TestCase
{
    #[Test]
    public function passes_if_currencies_match(): void
    {
        $currency = new MatchingCurrency('USD');
        $rule = new SameCurrencyRule();

        $deposit = $this->makeDeposit($currency);
        $cashout = $this->makeCashout($currency);

        $this->assertTrue($rule->passes($deposit, $cashout));
    }

    #[Test]
    public function fails_if_currencies_differ(): void
    {
        $rule = new SameCurrencyRule();

        $deposit = $this->makeDeposit(new MatchingCurrency('USD'));
        $cashout = $this->makeCashout(new MatchingCurrency('EUR'));

        $this->assertFalse($rule->passes($deposit, $cashout));
    }

    private function makeDeposit(MatchingCurrency $currency): MatchingDeposit
    {
        return new MatchingDeposit(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: $currency,
            project: new MatchingProject('project-1'),
            type: MatchingPaymentType::NORMAL
        );
    }

    private function makeCashout(MatchingCurrency $currency): MatchingCashout
    {
        return new MatchingCashout(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currency: $currency,
            project: new MatchingProject('project-1'),
            type: MatchingPaymentType::NORMAL
        );
    }
}
