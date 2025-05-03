<?php

declare(strict_types=1);

namespace Matcher\Tests\Matching\Domain\ValueObject;

use Matcher\Matching\Domain\ValueObject\MatchingPaymentType;
use Matcher\Payment\Domain\ValueObject\PaymentType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MatchingPaymentTypeTest extends TestCase
{
    #[Test]
    public function fromPaymentTypeMapsNormalCorrectly(): void
    {
        $result = MatchingPaymentType::fromPaymentType(PaymentType::NORMAL);
        $this->assertSame(MatchingPaymentType::NORMAL, $result);
    }

    #[Test]
    public function fromPaymentTypeMapsTestCorrectly(): void
    {
        $result = MatchingPaymentType::fromPaymentType(PaymentType::TEST);
        $this->assertSame(MatchingPaymentType::TEST, $result);
    }
}
