<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Domain\Entity\Deposit;

/**
 * @codeCoverageIgnore
 */
interface DepositRepositoryInterface
{
    public function save(Deposit $deposit): void;

    public function findById(string $id): ?Deposit;
}
