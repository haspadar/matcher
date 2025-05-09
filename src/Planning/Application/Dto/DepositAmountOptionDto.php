<?php

declare(strict_types=1);

namespace Matcher\Planning\Application\Dto;

final class DepositAmountOptionDto
{
    public function __construct(
        public readonly int $amount,
        public readonly int $count,
    ) {
    }
}
