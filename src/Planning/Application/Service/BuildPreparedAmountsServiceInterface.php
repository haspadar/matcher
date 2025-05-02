<?php

declare(strict_types=1);

namespace Matcher\Planning\Application\Service;

use Matcher\Shared\Domain\ValueObject\Uuid;

interface BuildPreparedAmountsServiceInterface
{
    public function buildByCashoutId(Uuid $cashoutId): void;
}
