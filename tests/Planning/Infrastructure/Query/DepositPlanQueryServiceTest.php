<?php

declare(strict_types=1);

namespace Matcher\Tests\Planning\Infrastructure\Query;

use Matcher\Planning\Application\Dto\DepositAmountOptionDto;
use Matcher\Planning\Domain\Repository\DepositPlanRepositoryInterface;
use Matcher\Planning\Infrastructure\Query\DepositPlanQueryService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DepositPlanQueryServiceTest extends TestCase
{
    private MockObject $repository;
    private DepositPlanQueryService $service;

    #[Test]
    public function returnsAmountsFromRepository(): void
    {
        $dto1 = new DepositAmountOptionDto('100', 2);
        $dto2 = new DepositAmountOptionDto('200', 1);

        $this->repository
            ->expects(self::once())
            ->method('findGroupedByAmount')
            ->with('project-1', 'USD')
            ->willReturn([$dto1, $dto2]);

        $result = $this->service->getAvailableDepositAmounts('project-1', 'USD');

        $this->assertSame([$dto1, $dto2], $result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(DepositPlanRepositoryInterface::class);
        $this->service = new DepositPlanQueryService($this->repository);
    }
}
