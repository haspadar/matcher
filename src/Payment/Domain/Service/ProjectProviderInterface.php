<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\Service;

use Matcher\Payment\Domain\ValueObject\PaymentProject;

/**
 * @codeCoverageIgnore
 */
interface ProjectProviderInterface
{
    public function getByCode(string $code): PaymentProject;
}
