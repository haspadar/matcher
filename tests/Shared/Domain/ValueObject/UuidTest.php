<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidUuidException;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UuidTest extends TestCase
{
    #[Test]
    public function createsFromStringIfValid(): void
    {
        $valid = '550e8400-e29b-41d4-a716-446655440000';
        $uuid = new Uuid($valid);
        $this->assertSame($valid, $uuid->value());
    }

    #[Test]
    public function trimUuid(): void
    {
        $valid = '550e8400-e29b-41d4-a716-446655440000';
        $uuid = new Uuid('  ' . $valid . '  ');
        $this->assertSame($valid, $uuid->value());
    }

    #[Test]
    public function generatesValidV4Uuid(): void
    {
        $uuid = Uuid::generate()->value();
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid
        );
    }

    #[Test]
    public function throwsExceptionForInvalidUuid(): void
    {
        $this->expectException(InvalidUuidException::class);
        new Uuid('invalid-uuid-string');
    }

    #[Test]
    public function throwsExceptionForUuidWithExtraCharacters(): void
    {
        $this->expectException(InvalidUuidException::class);
        new Uuid('550e8400-e29b-41d4-a716-446655440000xyz');
    }

    #[Test]
    public function throwsExceptionForUuidWithPrefix(): void
    {
        $this->expectException(InvalidUuidException::class);

        new Uuid('xxx-550e8400-e29b-41d4-a716-446655440000');
    }

    #[Test]
    public function isEqualsForSameUuid(): void
    {
        $uuid1 = new Uuid('550e8400-e29b-41d4-a716-446655440000');
        $uuid2 = new Uuid('550e8400-e29b-41d4-a716-446655440000');

        $this->assertTrue($uuid1->isEquals($uuid2));
    }

    #[Test]
    public function isNotEqualsForDifferentUuids(): void
    {
        $uuid1 = Uuid::generate();
        $uuid2 = Uuid::generate();

        $this->assertFalse($uuid1->isEquals($uuid2));
    }
}
