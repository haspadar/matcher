<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

use Matcher\Payment\Domain\Exception\InvalidProjectCodeException;
use Matcher\Shared\Domain\ValueObject\ValueObjectInterface;

final class ProjectCode implements ValueObjectInterface
{
    private string $code;

    public function __construct(string $code)
    {
        $code = strtoupper(trim($code)); // Приводим к верхнему регистру
        $this->validate($code);
        $this->code = $code;
    }

    public function value(): string
    {
        return $this->code;
    }

    private function validate(string $code): void
    {
        if (!preg_match('/^[A-Z0-9_-]+$/', $code)) {
            throw new InvalidProjectCodeException('Project code must contain only uppercase letters, numbers, underscores, and hyphens');
        }

        if (strlen($code) < 1 || strlen($code) > 255) {
            throw new InvalidProjectCodeException('Project code must be between 1 and 255 characters');
        }
    }
}
