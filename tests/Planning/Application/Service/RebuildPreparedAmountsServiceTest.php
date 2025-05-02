<?php

declare(strict_types=1);

namespace Matcher\Tests\Planning\Application\Service;

use Matcher\Planning\Application\Service\BuildPreparedAmountsServiceInterface;
use Matcher\Planning\Application\Service\RebuildPreparedAmountsService;
use Matcher\Planning\Domain\Repository\PreparedAmountRepositoryInterface;
use Matcher\Planning\Domain\ValueObject\PlanningCurrency;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RebuildPreparedAmountsServiceTest extends TestCase
{
    private MockObject $repository;
    private MockObject $builder;
    private RebuildPreparedAmountsService $service;

    #[Test]
    public function rebuildsPreparedAmountsByCurrency(): void
    {
        $currency = new PlanningCurrency('USD');
        $uuid1 = Uuid::generate();
        $uuid2 = Uuid::generate();

        $this->repository
            ->method('findNotPreparedCashoutIds')
            ->with($currency)
            ->willReturn([$uuid1, $uuid2]);

        $this->repository
            ->expects(self::exactly(2))
            ->method('deleteByCashoutId')
            ->with(self::callback(
                fn ($id) => $id instanceof Uuid && (
                    $id->value() === $uuid1->value() || $id->value() === $uuid2->value()
                )
            ));

        $this->builder
            ->expects(self::exactly(2))
            ->method('buildByCashoutId')
            ->with(self::callback(
                fn ($id) => $id instanceof Uuid && (
                    $id->value() === $uuid1->value() || $id->value() === $uuid2->value()
                )
            ));

        $this->service->rebuildByCurrency($currency);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PreparedAmountRepositoryInterface::class);
        $this->builder = $this->createMock(BuildPreparedAmountsServiceInterface::class);
        $this->service = new RebuildPreparedAmountsService($this->repository, $this->builder);
    }
}
