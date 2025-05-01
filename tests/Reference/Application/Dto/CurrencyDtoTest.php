<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Application\Dto;

use Matcher\Reference\Application\Dto\CurrencyDto;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyDtoTest extends TestCase
{
    #[Test]
    public function canCreateCurrencyDto(): void
    {
        // Arrange
        $code = 'USD';
        $amountStep = 100;

        // Act
        $currencyDto = new CurrencyDto($code, $amountStep);

        // Assert
        $this->assertSame($code, $currencyDto->code);
        $this->assertSame($amountStep, $currencyDto->amountStep);
    }
}
