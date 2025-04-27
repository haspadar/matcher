<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Currency;
use Matcher\Payment\Domain\Exception\InvalidCurrencyCodeException;
use Matcher\Payment\Domain\Repository\CurrencyRepositoryInterface;
use Matcher\Payment\Domain\ValueObject\CurrencyCode;
use Matcher\Payment\Domain\ValueObject\CurrencyName;
use Matcher\Payment\Domain\ValueObject\CurrencyPrecision;

class CurrencyService
{
    private CurrencyRepositoryInterface $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function createCurrency(string $currencyCode, string $currencyName, int $precision): Currency
    {
        $existingCurrency = $this->currencyRepository->findByCode($currencyCode);
        if ($existingCurrency) {
            throw new InvalidCurrencyCodeException('Currency code must be unique');
        }

        $currencyCodeVO = new CurrencyCode($currencyCode);
        $currencyNameVO = new CurrencyName($currencyName);
        $currencyPrecisionVO = new CurrencyPrecision($precision);

        return new Currency($currencyCodeVO, $currencyNameVO, $currencyPrecisionVO);
    }
}
