<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Infrastructure\Query;

use Matcher\Reference\Application\Dto\ProjectDto;
use Matcher\Reference\Domain\Entity\Project;
use Matcher\Reference\Domain\Repository\ProjectRepositoryInterface;
use Matcher\Reference\Domain\ValueObject\ProjectCode;
use Matcher\Reference\Infrastructure\Query\ProjectQueryService;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ProjectQueryServiceTest extends TestCase
{
    private MockObject $projectRepository;
    private ProjectQueryService $projectQueryService;

    #[Test]
    public function canFindProjectByCode(): void
    {
        $code = 'PROJECT_ABC';
        $project = new Project(
            id: Uuid::generate(),
            projectCode: new ProjectCode($code),
            isActive: true
        );

        $this->projectRepository
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn($project);

        $result = $this->projectQueryService->findByCode($code);

        $this->assertInstanceOf(ProjectDto::class, $result);
        $this->assertSame($code, $result->code);
        $this->assertTrue($result->isActive);
    }

    #[Test]
    public function returnsNullWhenProjectNotFound(): void
    {
        $code = 'PROJECT_XYZ';

        $this->projectRepository
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn(null);

        $result = $this->projectQueryService->findByCode($code);

        $this->assertNull($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectRepository = $this->createMock(ProjectRepositoryInterface::class);
        $this->projectQueryService = new ProjectQueryService($this->projectRepository);
    }
}
