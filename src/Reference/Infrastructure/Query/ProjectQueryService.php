<?php

declare(strict_types=1);

namespace Matcher\Reference\Infrastructure\Query;

use Matcher\Reference\Application\Dto\ProjectDto;
use Matcher\Reference\Application\Query\ProjectQueryServiceInterface;
use Matcher\Reference\Domain\Repository\ProjectRepositoryInterface;

final class ProjectQueryService implements ProjectQueryServiceInterface
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
    ) {
    }

    #[\Override]
    public function findByCode(string $code): ?ProjectDto
    {
        $project = $this->projectRepository->findByCode($code);

        if ($project === null) {
            return null;
        }

        return new ProjectDto(
            code: $project->getProjectCode()->value(),
            isActive: $project->isActive(),
        );
    }
}
