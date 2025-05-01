<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Service;

use Matcher\Reference\Domain\Entity\Bank;
use Matcher\Reference\Domain\Exception\InvalidBankNameException;
use Matcher\Reference\Domain\Repository\BankRepositoryInterface;
use Matcher\Reference\Domain\ValueObject\BankName;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class BankService
{
    private BankRepositoryInterface $bankRepository;

    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function createBank(string $name): Bank
    {
        $existingBank = $this->bankRepository->findByName($name);
        if ($existingBank) {
            throw new InvalidBankNameException('Bank name must be unique');
        }

        $bankName = new BankName($name);

        return new Bank(Uuid::generate(), $bankName);
    }
}
