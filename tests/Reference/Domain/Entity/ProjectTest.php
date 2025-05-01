<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\Entity;

use Matcher\Reference\Domain\Entity\Project;
use Matcher\Reference\Domain\ValueObject\ProjectCode;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ProjectTest extends TestCase
{
    #[Test]
    public function testReturnsCorrectValuesFromGetters(): void
    {
        $id = Uuid::generate();
        $projectCode = new ProjectCode('PROJECT_ABC');
        $isActive = false;

        $project = new Project(
            $id,
            $projectCode,
            $isActive
        );

        $this->assertEquals($id, $project->getId());
        $this->assertEquals($projectCode, $project->getProjectCode());
        $this->assertFalse($project->isActive());
    }
}
