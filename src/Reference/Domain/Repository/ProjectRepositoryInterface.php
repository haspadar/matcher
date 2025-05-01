<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Repository;

use Matcher\Reference\Domain\Entity\Project;

interface ProjectRepositoryInterface
{
    public function findByCode(string $code): ?Project;
    public function save(Project $project): void;
}
