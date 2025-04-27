<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidUuidException;

final class Uuid implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private string $uuid;

    private function __construct(string $uuid)
    {
        if (!self::isValid($uuid)) {
            throw new InvalidUuidException('Invalid UUID format');
        }

        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self(self::generateUuidV4());
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }

    public function value(): string
    {
        return $this->uuid;
    }

    private static function isValid(string $uuid): bool
    {
        return (bool)preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid,
        );
    }

    private static function generateUuidV4(): string
    {
        $data = random_bytes(16);

        // Установка версии UUID = 4
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        // Установка варианта RFC 4122
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4),
        );
    }
}
