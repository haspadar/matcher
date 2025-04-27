<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Bank;
use Matcher\Payment\Domain\Exception\InvalidBankNameException;
use Matcher\Payment\Domain\Repository\BankRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\BankName;
use Matcher\Shared\Domain\ValueObject\Uuid;

class BankService
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

        $bank = new Bank(Uuid::generate(), $bankName);

        return $bank;
    }
}
