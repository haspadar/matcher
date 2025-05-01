<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Infrastructure\Reference;

use Matcher\Payment\Domain\Service\CurrencyProviderInterface;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Infrastructure\Reference\CurrencyProviderFromReference;
use Matcher\Reference\Application\Dto\CurrencyDto;
use Matcher\Reference\Application\Query\CurrencyQueryServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CurrencyProviderFromReferenceTest extends TestCase
{
    private MockObject $currencyQueryService;
    private CurrencyProviderInterface $currencyProvider;

    #[Test]
    public function canGetCurrencyByCode(): void
    {
        $code = 'USD';
        $currencyDto = new CurrencyDto(
            code: $code,
            amountStep: 100
        );

        $this->currencyQueryService
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn($currencyDto);

        $currency = $this->currencyProvider->getByCode($code);

        $this->assertInstanceOf(PaymentCurrency::class, $currency);
        $this->assertSame($code, $currency->code);
        $this->assertSame(100, $currency->amountStep);
    }

    #[Test]
    public function throwsExceptionWhenCurrencyNotFound(): void
    {
        $code = 'USD';

        $this->currencyQueryService
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn(null);

        $this->expectException(\DomainException::class);

        $this->currencyProvider->getByCode($code);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyQueryService = $this->createMock(CurrencyQueryServiceInterface::class);
        $this->currencyProvider = new CurrencyProviderFromReference($this->currencyQueryService);
    }
}
