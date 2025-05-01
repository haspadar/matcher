<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\ValueObject;

use Matcher\Reference\Domain\Exception\InvalidProjectCodeException;
use Matcher\Reference\Domain\ValueObject\ProjectCode;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ProjectCodeTest extends TestCase
{
    #[Test]
    public function canCreateValidProjectCode(): void
    {
        $projectCode = new ProjectCode('PROJECT_001');
        $this->assertSame('PROJECT_001', $projectCode->value());
    }

    #[Test]
    public function trimsProjectCode(): void
    {
        $projectCode = new ProjectCode('  PROJ  ');
        $this->assertSame('PROJ', $projectCode->value());
    }

    #[Test]
    public function throwsExceptionForInvalidCodeWithSpecialCharacters(): void
    {
        $this->expectException(InvalidProjectCodeException::class);
        new ProjectCode('PROJECT@001');
    }

    #[Test]
    public function throwsExceptionForTooShortCode(): void
    {
        $this->expectException(InvalidProjectCodeException::class);
        new ProjectCode(''); // Now accepts 1 character, so empty string should throw an exception
    }

    #[Test]
    public function throwsExceptionForTooLongCode(): void
    {
        $this->expectException(InvalidProjectCodeException::class);
        new ProjectCode(str_repeat('P', 256)); // Too long code
    }

    #[Test]
    public function allowsValidCodeWithHyphenAndUnderscore(): void
    {
        $projectCode = new ProjectCode('PROJECT-001_TEST');
        $this->assertSame('PROJECT-001_TEST', $projectCode->value());
    }

    #[Test]
    public function automaticallyConvertsToUppercase(): void
    {
        $projectCode = new ProjectCode('project_001');
        $this->assertSame('PROJECT_001', $projectCode->value()); // Ensure it is converted to uppercase
    }

    #[Test]
    public function acceptsMinimumLengthCode(): void
    {
        $code = new ProjectCode('A');
        $this->assertSame('A', $code->value());
    }

    #[Test]
    public function acceptsMaximumLengthCode(): void
    {
        $code = str_repeat('P', 255);
        $projectCode = new ProjectCode($code);
        $this->assertSame($code, $projectCode->value());
    }
}
