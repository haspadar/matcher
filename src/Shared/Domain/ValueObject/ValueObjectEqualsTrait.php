<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
trait ValueObjectEqualsTrait
{
    public function isEquals(ValueObjectInterface $other): bool
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->value() === $other->value();
    }
}
