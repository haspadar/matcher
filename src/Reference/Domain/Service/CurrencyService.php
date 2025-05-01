<?php

declare(strict_types=1);

namespace Matcher\Reference\Domain\Service;

use Matcher\Reference\Domain\Entity\Currency;
use Matcher\Shared\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Reference\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Reference\Domain\ValueObject\AmountStep;
use Matcher\Shared\Domain\ValueObject\CurrencyCode;
use Matcher\Reference\Domain\ValueObject\CurrencyName;
use Matcher\Shared\Domain\ValueObject\CurrencyPrecision;
use Matcher\Reference\Domain\ValueObject\Multiplicity;
use Matcher\Shared\Domain\ValueObject\Uuid;

final class CurrencyService
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
        );
    }
}
