<?php

declare(strict_types=1);

namespace Matcher\Payment\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
enum Type: string
{
    case NORMAL = 'normal';

    case TEST = 'test';
}
