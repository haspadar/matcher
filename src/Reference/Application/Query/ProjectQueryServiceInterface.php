<?php

declare(strict_types=1);

namespace Matcher\Reference\Application\Query;

use Matcher\Reference\Application\Dto\ProjectDto;

interface ProjectQueryServiceInterface
{
    public function findByCode(string $code): ?ProjectDto;
}
