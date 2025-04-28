<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidCardNumberException;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CardNumberTest extends TestCase
{
    #[Test]
    public function itCreatesValidCardNumber(): void
    {
        $cardNumber = new CardNumber('1234567890123456');

        $this->assertSame('1234567890123456', $cardNumber->value());
    }

    #[Test]
    public function itThrowsExceptionForInvalidCardNumberTooShort(): void
    {
        $this->expectException(InvalidCardNumberException::class);

        new CardNumber('1234567890');
    }

    #[Test]
    public function itThrowsExceptionForInvalidCardNumberTooLong(): void
    {
        $this->expectException(InvalidCardNumberException::class);

        new CardNumber('12345678901234567890');
    }

    #[Test]
    public function itThrowsExceptionForNonNumericCardNumber(): void
    {
        $this->expectException(InvalidCardNumberException::class);

        new CardNumber('1234ABC678901234');
    }

    #[Test]
    public function itReturnsBinFromCardNumber(): void
    {
        $cardNumber = new CardNumber('1234567890123456');

        $this->assertSame('123456', $cardNumber->getBin());
    }
}
