<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\ValueObject\UserId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserIdTest extends TestCase
{
    #[Test]
    public function canCreateValidUserId(): void
    {
        $userId = new UserId(123);
        $this->assertSame(123, $userId->value());
    }

    #[Test]
    public function throwsExceptionForNonPositiveUserId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserId(0);
    }

    #[Test]
    public function throwsExceptionForNegativeUserId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserId(-1);
    }
}
