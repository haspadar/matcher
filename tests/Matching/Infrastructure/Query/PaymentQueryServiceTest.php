<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Infrastructure\Query;

use Matcher\Matching\Domain\ValueObject\MatchingCashout;
use Matcher\Matching\Domain\ValueObject\MatchingDeposit;
use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Infrastructure\Query\PaymentQueryService;
use Matcher\Payment\Application\Dto\DepositDto;
use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Payment\Domain\Repository\DepositRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PaymentQueryServiceTest extends TestCase
{
    private MockObject $depositRepository;
    private MockObject $cashoutRepository;
    private PaymentQueryService $service;

    #[Test]
    public function returnsMatchingDeposits(): void
    {
        $deposit = new DepositDto(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(1000),
            currencyCode: 'USD',
            projectCode: 'project-1',
            type: PaymentType::TEST
        );

        $this->depositRepository
            ->method('findByStatuses')
            ->willReturn([$deposit]);

        $result = $this->service->findDepositsByStatus([]);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(MatchingDeposit::class, $result[0]);
        $this->assertSame('USD', $result[0]->currency->code);
        $this->assertSame('project-1', $result[0]->project->code);
        $this->assertSame(MatchingPaymentType::TEST, $result[0]->type);
    }

    #[Test]
    public function returnsMatchingCashouts(): void
    {
        $cashout = new CashoutDto(
            id: Uuid::generate(),
            amount: new PositiveIntegerAmount(2000),
            currencyCode: 'EUR',
            projectCode: 'project-2',
            type: PaymentType::NORMAL
        );

        $this->cashoutRepository
            ->method('findByStatuses')
            ->willReturn([$cashout]);

        $result = $this->service->findCashoutsByStatus([]);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(MatchingCashout::class, $result[0]);
        $this->assertSame('EUR', $result[0]->currency->code);
        $this->assertSame('project-2', $result[0]->project->code);
        $this->assertSame(MatchingPaymentType::NORMAL, $result[0]->type);
    }

    protected function setUp(): void
    {
        $this->depositRepository = $this->createMock(DepositRepositoryInterface::class);
        $this->cashoutRepository = $this->createMock(CashoutRepositoryInterface::class);
        $this->service = new PaymentQueryService($this->depositRepository, $this->cashoutRepository);
    }
}
