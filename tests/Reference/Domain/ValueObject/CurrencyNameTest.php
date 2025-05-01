<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidCurrencyNameException;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyNameTest extends TestCase
{
    #[Test]
    public function canCreateValidCurrencyName(): void
    {
        $name = new CurrencyName('us dollar');

        $this->assertSame('Us Dollar', $name->value());
    }

    #[Test]
    public function normalizesNameToUcwords(): void
    {
        $name = new CurrencyName('eUroPeAn dOLlar');

        $this->assertSame('European Dollar', $name->value());
    }

    #[Test]
    public function trimName(): void
    {
        $name = new CurrencyName(' Dollar ');

        $this->assertSame('Dollar', $name->value());
    }

    #[Test]
    public function throwsExceptionWhenNameIsTooLong(): void
    {
        $this->expectException(InvalidCurrencyNameException::class);

        $tooLongName = str_repeat('a', 256);

        new CurrencyName($tooLongName);
    }

    #[Test]
    public function allowsNameWithExactly255Characters(): void
    {
        $name = str_repeat('a', 255);
        $currencyName = new CurrencyName($name);

        $this->assertSame(ucwords($name), $currencyName->value());
    }
}
