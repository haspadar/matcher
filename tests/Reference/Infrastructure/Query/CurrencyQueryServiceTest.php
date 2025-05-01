<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Infrastructure\Query;

use Matcher\Reference\Application\Dto\CurrencyDto;
use Matcher\Reference\Domain\Entity\Currency;
use Matcher\Reference\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Reference\Domain\ValueObject\AmountStep;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use Matcher\Reference\Infrastructure\Query\CurrencyQueryService;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CurrencyQueryServiceTest extends TestCase
{
    private MockObject $currencyRepository;
    private CurrencyQueryService $currencyQueryService;

    #[Test]
    public function canFindCurrencyByCode(): void
    {
        // Arrange
        $code = 'USD';
        $currency = new Currency(
            id: Uuid::generate(),
            code: new CurrencyCode($code),
            name: new CurrencyName('US Dollar'),
            precision: new CurrencyPrecision(2),
            multiplicity: new Multiplicity(10),
            amountStep: new AmountStep(100)
        );

        $this->currencyRepository
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn($currency);

        $result = $this->currencyQueryService->findByCode($code);

        $this->assertInstanceOf(CurrencyDto::class, $result);
        $this->assertSame($code, $result->code);
        $this->assertSame(100, $result->amountStep);
    }

    #[Test]
    public function returnsNullWhenCurrencyNotFound(): void
    {
        // Arrange
        $code = 'EUR';

        $this->currencyRepository
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn(null);

        $result = $this->currencyQueryService->findByCode($code);

        $this->assertNull($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyRepository = $this->createMock(CurrencyRepositoryInterface::class);
        $this->currencyQueryService = new CurrencyQueryService($this->currencyRepository);
    }
}
