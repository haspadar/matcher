<?php

declare(strict_types=1);

namespace Matcher\Payment\Infrastructure\Reference;

use DomainException;
use Matcher\Payment\Domain\Service\ProjectProviderInterface;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Reference\Application\Query\ProjectQueryServiceInterface;
use Override;

final class ProjectProviderFromReference implements ProjectProviderInterface
{
    public function __construct(
        private readonly ProjectQueryServiceInterface $referenceProjectQuery,
    ) {
    }

    #[Override]
    public function getByCode(string $code): PaymentProject
    {
        $dto = $this->referenceProjectQuery->findByCode($code);

        if ($dto === null) {
            throw new DomainException("Project with code '{$code}' not found");
        }

        return new PaymentProject(
            code: $dto->code,
            isActive: $dto->isActive
        );
    }
}
