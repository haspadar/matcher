<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\ValueObject\PaymentProject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PaymentProjectTest extends TestCase
{
    #[Test]
    public function canCreatePaymentProject(): void
    {
        $paymentProject = new PaymentProject('ProjectX', true);

        $this->assertSame('ProjectX', $paymentProject->code);
        $this->assertTrue($paymentProject->isActive);
    }
}
