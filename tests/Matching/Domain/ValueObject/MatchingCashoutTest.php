<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\ValueObject;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MatchingCashoutTest extends TestCase
{
    #[Test]
    public function createsCashoutFromDto(): void
    {
        $dto = new CashoutDto(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1500),
            currencyCode: 'EUR',
            projectCode: 'project-2',
            type: PaymentType::NORMAL, // должен быть PaymentType, не Matching
        );

        $cashout = MatchingCashout::fromPaymentDto($dto);

        $this->assertSame($dto->id->value(), $cashout->id->value());
        $this->assertSame(1500, $cashout->amount->value());
        $this->assertSame('EUR', $cashout->currency->code);
        $this->assertSame('project-2', $cashout->project->code);
        $this->assertSame(MatchingPaymentType::NORMAL, $cashout->type);
    }
}
