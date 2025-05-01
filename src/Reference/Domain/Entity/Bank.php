<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Entity;

use Matcher\Reference\Domain\ValueObject\BankName;
use Matcher\Shared\Domain\Entity\EntityInterface;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class Bank implements EntityInterface
{
    public function __construct(private Uuid $id, private BankName $name)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): BankName
    {
        return $this->name;
    }

    public function equals(self $other): bool
    {
        return $this->id === $other->getId();
    }
}
