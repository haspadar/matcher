<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\Service;

use Matcher\Reference\Domain\Entity\Currency;
use Matcher\Reference\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Reference\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Reference\Domain\Service\CurrencyService;
use Matcher\Reference\Domain\ValueObject\AmountStep;
use Matcher\Reference\Domain\ValueObject\CurrencyCode;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use Matcher\Reference\Domain\ValueObject\CurrencyPrecision;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CurrencyServiceTest extends TestCase
{
    private MockObject $currencyRepository;
    private CurrencyService $currencyService;

    #[Test]
    public function canCreateValidCurrency(): void
    {
        $this->currencyRepository->method('findByCode')->willReturn(null);

        $currency = $this->currencyService->createCurrency(
            'USD',
            'US Dollar',
            2,
            10,
            100
        );

        // Приводим строку к нужному виду, проверяя первую заглавную букву в каждом слове
        $this->assertSame('USD', $currency->getCode()->value());
        $this->assertSame('Us Dollar', $currency->getName()->value());  // Теперь проверяем результат с нормализованным регистром
        $this->assertSame(2, $currency->getPrecision()->value());
    }

    #[Test]
    public function throwsExceptionForNonUniqueCurrencyCode(): void
    {
        $this->currencyRepository->method('findByCode')->willReturn(
            new Currency(
                Uuid::generate(),
                new CurrencyCode('USD'),
                new CurrencyName('US Dollar'),
                new CurrencyPrecision(2),
                new Multiplicity(10),
                new AmountStep(100),
            )
        );

        $this->expectException(InvalidCurrencyCodeException::class);

        $this->currencyService->createCurrency('USD', 'US Dollar', 2, 10, 100);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyRepository = $this->createMock(CurrencyRepositoryInterface::class);
        $this->currencyService = new CurrencyService($this->currencyRepository);
    }
}
