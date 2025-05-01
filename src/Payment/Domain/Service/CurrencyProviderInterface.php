<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\ValueObject\PaymentCurrency;

/**
 * @codeCoverageIgnore
 */
interface CurrencyProviderInterface
{
    public function getByCode(string $code): PaymentCurrency;
}
