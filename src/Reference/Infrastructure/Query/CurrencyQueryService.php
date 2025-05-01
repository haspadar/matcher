<?php

declare(strict_types=1);

namespace Matcher\Reference\Infrastructure\Query;

use Matcher\Reference\Application\Dto\CurrencyDto;
use Matcher\Reference\Application\Query\CurrencyQueryServiceInterface;
use Matcher\Reference\Domain\Repository\CurrencyRepositoryInterface;

final class CurrencyQueryService implements CurrencyQueryServiceInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    #[\Override]
    public function findByCode(string $code): ?CurrencyDto
    {
        $currency = $this->currencyRepository->findByCode($code);

        if ($currency === null) {
            return null;
        }

        return new CurrencyDto(
            code: $currency->getCode()->value(),
            amountStep: $currency->getAmountStep()->value(),
        );
    }
}
