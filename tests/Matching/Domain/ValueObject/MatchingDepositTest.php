<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\ValueObject;

use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Payment\Application\Dto\DepositDto;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MatchingDepositTest extends TestCase
{
    #[Test]
    public function createsDepositFromDto(): void
    {
        $dto = new DepositDto(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currencyCode: 'USD',
            projectCode: 'project-1',
            type: PaymentType::TEST, // вот здесь замена
        );

        $deposit = MatchingDeposit::fromPaymentDto($dto);

        $this->assertSame($dto->id->value(), $deposit->id->value());
        $this->assertSame(1000, $deposit->amount->value());
        $this->assertSame('USD', $deposit->currency->code);
        $this->assertSame('project-1', $deposit->project->code);
        $this->assertSame(MatchingPaymentType::TEST, $deposit->type);
    }
}
