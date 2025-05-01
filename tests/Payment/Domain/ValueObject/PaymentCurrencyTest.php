<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PaymentCurrencyTest extends TestCase
{
    #[Test]
    public function canCreatePaymentCurrency(): void
    {
        $paymentCurrency = new PaymentCurrency('USD', 100);

        $this->assertSame('USD', $paymentCurrency->code);
        $this->assertSame(100, $paymentCurrency->amountStep);
    }
}
