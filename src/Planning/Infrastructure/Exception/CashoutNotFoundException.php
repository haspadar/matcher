<?php

declare(strict_types=1);

namespace Matcher\Planning\Infrastructure\Exception;

use Matcher\Shared\Domain\Exception\DomainException;
use Matcher\Shared\Domain\Exception\ErrorCodeTrait;
use Matcher\Shared\Domain\ValueObject\Uuid;

/**
 * @codeCoverageIgnore
 */
final class CashoutNotFoundException extends DomainException
{
    use ErrorCodeTrait;

    protected const string ERROR_CODE = 'cashout_not_found';

    public function __construct(Uuid $id)
    {
        parent::__construct("Cashout with ID {$id->value()} not found");
    }
}
