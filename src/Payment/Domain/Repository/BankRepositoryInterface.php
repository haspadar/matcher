<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Domain\Entity\Bank;

interface BankRepositoryInterface
{
    public function findByName(string $name): ?Bank;
}
