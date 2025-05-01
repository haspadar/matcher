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
        return new self(self::generateUuidV4());
    }

    #[\Override]
    public function value(): string
    {
        return $this->uuid;
    }

    public function validate(string $uuid): void
    {
        if (!preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid
        )) {
            throw new InvalidUuidException('Invalid UUID format');
        }
    }

    private static function generateUuidV4(): string
    {
        $data = random_bytes(16); // Generates 16 random bytes

        // Set the version of the UUID to 4
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        // Set the variant according to RFC 4122
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf(
            '%s%s-%s-%s-%s-%s%s%s', // Formats the UUID into the standard hexadecimal format
            str_split(bin2hex($data), 4) // Converts the random data to hexadecimal and splits it into chunks
        );
    }
}
