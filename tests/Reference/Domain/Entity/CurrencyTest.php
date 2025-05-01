<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\Entity;

use Matcher\Reference\Domain\Entity\Currency;
use Matcher\Reference\Domain\ValueObject\AmountStep;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyTest extends TestCase
{
    #[Test]
    public function returnsCorrectValuesFromGetters(): void
    {
        $id = Uuid::generate();
        $currency = new Currency(
            $id,
            new CurrencyCode('USD'),
            new CurrencyName('US Dollar'),
            new CurrencyPrecision(2),
            new Multiplicity(10),
            new AmountStep(100)
        );

        $this->assertEquals($id, $currency->getId());
        $this->assertEquals(new CurrencyCode('USD'), $currency->getCode());
        $this->assertEquals(new CurrencyName('US Dollar'), $currency->getName());
        $this->assertEquals(new CurrencyPrecision(2), $currency->getPrecision());
        $this->assertEquals(new Multiplicity(10), $currency->getMultiplicity());
        $this->assertEquals(new AmountStep(100), $currency->getAmountStep());
    }
}
