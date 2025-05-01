<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidUrlException;
use Matcher\Shared\Domain\ValueObject\Url;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    #[Test]
    public function canCreateValidUrl(): void
    {
        $url = new Url('https://example.com');
        $this->assertSame('https://example.com', $url->value());
    }

    #[Test]
    public function trimUrl(): void
    {
        $url = new Url('  https://example.com  ');
        $this->assertSame('https://example.com', $url->value());
    }


    #[Test]
    public function throwsExceptionForEmptyUrl(): void
    {
        $this->expectException(InvalidUrlException::class);
        new Url('');
    }

    #[Test]
    public function throwsExceptionForInvalidUrl(): void
    {
        $this->expectException(InvalidUrlException::class);
        new Url('invalid-url');
    }

    #[Test]
    public function throwsExceptionForMissingSchemeUrl(): void
    {
        $this->expectException(InvalidUrlException::class);
        new Url('example.com');
    }
}
