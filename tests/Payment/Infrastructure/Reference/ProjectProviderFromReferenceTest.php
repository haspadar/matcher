<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Infrastructure\Reference;

use Matcher\Payment\Domain\Service\ProjectProviderInterface;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Infrastructure\Reference\ProjectProviderFromReference;
use Matcher\Reference\Application\Dto\ProjectDto;
use Matcher\Reference\Application\Query\ProjectQueryServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ProjectProviderFromReferenceTest extends TestCase
{
    private MockObject $projectQueryService;
    private ProjectProviderInterface $projectProvider;

    #[Test]
    public function canGetProjectByCode(): void
    {
        $code = 'PROJECT_ABC';
        $projectDto = new ProjectDto(
            code: $code,
            isActive: true
        );

        $this->projectQueryService
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn($projectDto);

        $project = $this->projectProvider->getByCode($code);

        $this->assertInstanceOf(PaymentProject::class, $project);
        $this->assertSame($code, $project->code);
        $this->assertTrue($project->isActive);
    }

    #[Test]
    public function throwsExceptionWhenProjectNotFound(): void
    {
        $code = 'PROJECT_ABC';

        $this->projectQueryService
            ->expects(self::once())
            ->method('findByCode')
            ->with($code)
            ->willReturn(null);

        $this->expectException(\DomainException::class);

        $this->projectProvider->getByCode($code);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectQueryService = $this->createMock(ProjectQueryServiceInterface::class);
        $this->projectProvider = new ProjectProviderFromReference($this->projectQueryService);
    }
}
