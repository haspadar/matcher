<?php

declare(strict_types=1);

namespace Matcher\Reference\Application\Query;

use Matcher\Reference\Application\Dto\CurrencyDto;

interface CurrencyQueryServiceInterface
{
    public function findByCode(string $code): ?CurrencyDto;
}
