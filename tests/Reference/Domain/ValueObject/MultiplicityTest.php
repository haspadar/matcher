<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidMultiplicityException;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MultiplicityTest extends TestCase
{
    #[Test]
    public function canCreateValidMultiplicity(): void
    {
        $multiplicity = new Multiplicity(20);
        $this->assertSame(20, $multiplicity->value());
    }

    #[Test]
    public function throwsExceptionForNonMultipleOfTen(): void
    {
        $this->expectException(InvalidMultiplicityException::class);
        new Multiplicity(15);
    }

    #[Test]
    public function throwsExceptionForZero(): void
    {
        $this->expectException(InvalidMultiplicityException::class);
        new Multiplicity(0);
    }

    #[Test]
    public function allowsMultipleOfTen(): void
    {
        $multiplicity = new Multiplicity(30);
        $this->assertSame(30, $multiplicity->value());
    }
}
