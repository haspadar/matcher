<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\ValueObject;

use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Matching\Domain\ValueObject\MatchingType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MatchingTypeTest extends TestCase
{
    #[Test]
    public function returnsNormalIfBothTypesAreNormal(): void
    {
        $type = MatchingType::fromPaymentType(
            MatchingPaymentType::NORMAL,
            MatchingPaymentType::NORMAL
        );

        $this->assertSame(MatchingType::NORMAL, $type);
    }

    #[Test]
    public function returnsTestIfBothTypesAreTest(): void
    {
        $type = MatchingType::fromPaymentType(
            MatchingPaymentType::TEST,
            MatchingPaymentType::TEST
        );

        $this->assertSame(MatchingType::TEST, $type);
    }

    #[Test]
    public function returnsTestIfTypesDiffer(): void
    {
        $type = MatchingType::fromPaymentType(
            MatchingPaymentType::NORMAL,
            MatchingPaymentType::TEST
        );

        $this->assertSame(MatchingType::TEST, $type);
    }
}
