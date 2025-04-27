<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Repository;

use Matcher\Payment\Domain\Entity\Currency;

interface CurrencyRepositoryInterface
{
    public function findByCode(string $code): ?Currency;
}
