<?php

declare(strict_types=1);

namespace Matcher\Matching\Domain\ValueObject;

use Matcher\Payment\Application\Dto\CashoutDto;
use Matcher\Shared\Domain\ValueObject\PositiveIntegerAmount;
use Matcher\Shared\Domain\ValueObject\Uuid;

final readonly class MatchingCashout
{
    public function __construct(
        public Uuid $id,
        public PositiveIntegerAmount $amount,
        public MatchingCurrency $currency,
        public MatchingProject $project,
        public MatchingPaymentType $type,
    ) {
    }

    public static function fromPaymentDto(CashoutDto $dto): self
    {
        return new self(
            id: $dto->id,
            amount: $dto->amount,
            currency: new MatchingCurrency($dto->currencyCode),
            project: new MatchingProject($dto->projectCode),
            type: MatchingPaymentType::fromPaymentType($dto->type),
        );
    }
}
