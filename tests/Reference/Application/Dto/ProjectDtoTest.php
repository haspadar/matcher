<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Application\Dto;

use Matcher\Reference\Application\Dto\ProjectDto;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ProjectDtoTest extends TestCase
{
    #[Test]
    public function canCreateProjectDto(): void
    {
        // Arrange
        $code = 'PROJECT_ABC';
        $isActive = true;

        // Act
        $projectDto = new ProjectDto($code, $isActive);

        // Assert
        $this->assertSame($code, $projectDto->code);
        $this->assertSame($isActive, $projectDto->isActive);
    }
}
