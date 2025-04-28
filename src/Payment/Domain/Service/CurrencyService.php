<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Currency;
use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Payment\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\AmountStep;
use Matcher\Payment\Domain\ValueObject\CurrencyCode;
use Matcher\Payment\Domain\ValueObject\CurrencyName;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;
use Matcher\Payment\Domain\ValueObject\Multiplicity;
use Matcher\Payment\Domain\ValueObject\Status;
use Matcher\Shared\Domain\ValueObject\Uuid;

class CurrencyService
{
    private CurrencyRepositoryInterface $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function createCurrency(string $currencyCode, string $currencyName, int $precision, int $multiplicity, int $amountStep): Currency
    {
        $existingCurrency = $this->currencyRepository->findByCode($currencyCode);
        if ($existingCurrency) {
            throw new InvalidCurrencyCodeException('Currency code must be unique');
        }

        return new Currency(
            Uuid::generate(),
            new CurrencyCode($currencyCode),
            new CurrencyName($currencyName),
            new CurrencyPrecision($precision),
            new Multiplicity($multiplicity),
            new AmountStep($amountStep),
            Status::NEW
        );
    }
}
