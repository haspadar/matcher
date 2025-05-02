<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidUuidException;

final class Uuid implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private string $uuid;

    public function __construct(string $uuid)
    {
        $uuid = trim($uuid);
        $this->validate($uuid);

        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    #[\Override]
    public function value(): string
    {
        return $this->uuid;
    }

    private function validate(string $uuid): void
    {
        if (!\Ramsey\Uuid\Uuid::isValid($uuid)) {
            throw new InvalidUuidException('Invalid UUID format');
        }
    }
}
