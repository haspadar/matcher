<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Application\Service;

use Matcher\Payment\Application\Service\DepositPlanningService;
use Matcher\Planning\Application\Dto\DepositAmountOptionDto;
use Matcher\Planning\Application\Query\DepositPlanQueryInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DepositPlanningServiceTest extends TestCase
{
    private MockObject $depositPlanQuery;
    private DepositPlanningService $depositPlanningService;

    #[Test]
    public function returnsAvailableDepositAmounts(): void
    {
        $this->depositPlanQuery
            ->expects(self::once())
            ->method('getAvailableDepositAmounts')
            ->with('project-1', 'USD')
            ->willReturn([
                new DepositAmountOptionDto(100, 2),
                new DepositAmountOptionDto(200, 1),
            ]);

        $result = $this->depositPlanningService->getAvailableDepositAmounts('project-1', 'USD');

        $this->assertCount(2, $result);
        $this->assertSame(100, $result[0]->amount);
        $this->assertSame(2, $result[0]->count);
        $this->assertSame(200, $result[1]->amount);
        $this->assertSame(1, $result[1]->count);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->depositPlanQuery = $this->createMock(DepositPlanQueryInterface::class);
        $this->depositPlanningService = new DepositPlanningService($this->depositPlanQuery);
    }
}
