<?php

declare(strict_types=1);

namespace Matcher\Tests\Reference\Domain\Service;

use Matcher\Reference\Domain\Entity\Bank;
use Matcher\Reference\Domain\Exception\InvalidBankNameException;
use Matcher\Reference\Domain\Repository\BankRepositoryInterface;
use Matcher\Reference\Domain\Service\BankService;
use Matcher\Reference\Domain\ValueObject\BankName;
use Matcher\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class BankServiceTest extends TestCase
{
    private MockObject $bankRepository;
    private BankService $bankService;

    #[Test]
    public function canCreateValidBank(): void
    {
        $this->bankRepository->method('findByName')->willReturn(null);

        $bank = $this->bankService->createBank('Sberbank');

        $this->assertSame('Sberbank', $bank->getName()->value());
    }

    #[Test]
    public function throwsExceptionForNonUniqueName(): void
    {
        $this->bankRepository->method('findByName')->willReturn(new Bank(Uuid::generate(), new BankName('Sberbank')));

        $this->expectException(InvalidBankNameException::class);

        $this->bankService->createBank('Sberbank');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->bankRepository = $this->createMock(BankRepositoryInterface::class);
        $this->bankService = new BankService($this->bankRepository);
    }
}
