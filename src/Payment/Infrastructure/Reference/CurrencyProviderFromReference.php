<?php

declare(strict_types=1);

namespace Matcher\Payment\Infrastructure\Reference;

use Matcher\Payment\Domain\Service\CurrencyProviderInterface;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Reference\Application\Query\CurrencyQueryServiceInterface;

final class CurrencyProviderFromReference implements CurrencyProviderInterface
{
    public function __construct(
        private readonly CurrencyQueryServiceInterface $referenceCurrencyQuery,
    ) {
    }

    #[\Override]
    public function getByCode(string $code): PaymentCurrency
    {
        $dto = $this->referenceCurrencyQuery->findByCode($code);

        if ($dto === null) {
            throw new \DomainException("Currency with code '$code' not found");
        }

        return new PaymentCurrency(
            code: $dto->code,
            amountStep: $dto->amountStep,
        );
    }
}
