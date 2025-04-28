<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class UserId implements ValueObjectInterface
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->validate($userId);
        $this->userId = $userId;
    }

    public function value(): int
    {
        return $this->userId;
    }

    public function validate(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException('User ID must be a positive integer');
        }
    }
}
