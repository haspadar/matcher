<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

interface RequisiteInterface extends ValueObjectInterface
{
    #[\Override]
    public function value(): string;
    public function validate(string $value): void;
}
