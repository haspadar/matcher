<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Application\Dto\DepositDto;
use Matcher\Payment\Domain\Entity\Deposit;
use Matcher\Payment\Domain\ValueObject\DepositStatus;

/**
 * @codeCoverageIgnore
 */
interface DepositRepositoryInterface
{
    public function save(Deposit $deposit): void;

    public function findById(string $id): ?Deposit;

    /**
     * @param  DepositStatus[]  $statuses
     * @return DepositDto[]
     */
    public function findByStatuses(array $statuses): array;
}
