<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Entity;

use Matcher\Payment\Domain\ValueObject\ProjectCode;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Project implements EntityInterface
{
    public function __construct(
        private Uuid $id,
        private ProjectCode $projectCode,
        private bool $isActive,
    ) {

    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProjectCode(): ProjectCode
    {
        return $this->projectCode;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
