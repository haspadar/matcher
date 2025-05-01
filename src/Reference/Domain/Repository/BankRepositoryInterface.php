<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Repository;

use Matcher\Reference\Domain\Entity\Bank;

interface BankRepositoryInterface
{
    public function findByName(string $name): ?Bank;
    public function save(Bank $bank): void;
}
