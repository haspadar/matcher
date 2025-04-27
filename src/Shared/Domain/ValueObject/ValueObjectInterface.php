<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

interface ValueObjectInterface
{
    public function value(): mixed;
}
