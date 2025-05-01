<?php

declare(strict_types=1);

namespace Matcher\Reference\Application\Dto;

final class CurrencyDto
{
    public function __construct(
        public readonly string $code,
        public readonly int $amountStep,
    ) {
    }
}
