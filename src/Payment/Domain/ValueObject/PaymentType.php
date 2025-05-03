<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
enum PaymentType: string
{
    case NORMAL = 'normal';

    case TEST = 'test';
}
