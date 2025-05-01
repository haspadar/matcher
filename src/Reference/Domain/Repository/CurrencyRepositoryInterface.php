<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Repository;

use Matcher\Reference\Domain\Entity\Currency;

interface CurrencyRepositoryInterface
{
    public function findByCode(string $code): ?Currency;
    public function save(Currency $currency): void;
}
