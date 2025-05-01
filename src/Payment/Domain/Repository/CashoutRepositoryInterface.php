<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Domain\Entity\Cashout;

/**
 * @codeCoverageIgnore
 */
interface CashoutRepositoryInterface
{
    public function save(Cashout $cashout): void;

    public function findById(string $id): ?Cashout;
}
