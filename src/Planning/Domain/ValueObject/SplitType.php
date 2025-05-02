<?php

declare(strict_types=1);

namespace Matcher\Planning\Domain\ValueObject;

enum SplitType: string
{
    case MAIN = 'main';
    case REMAIN = 'remain';
}
