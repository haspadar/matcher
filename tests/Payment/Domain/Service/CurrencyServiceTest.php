<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Currency;
use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Payment\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Payment\Domain\Service\CurrencyService;
use Matcher\Payment\Domain\ValueObject\CurrencyCode;
use Matcher\Payment\Domain\ValueObject\CurrencyName;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;
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

        $currency = $this->currencyService->createCurrency('USD', 'US Dollar', 2);

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
            )
        );

        $this->expectException(InvalidCurrencyCodeException::class);

        $this->currencyService->createCurrency('USD', 'US Dollar', 2);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyRepository = $this->createMock(CurrencyRepositoryInterface::class);
        $this->currencyService = new CurrencyService($this->currencyRepository);
    }
}
