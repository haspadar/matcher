<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidAmountException;

/**
 * @psalm-suppress
 */
final class Amount implements ValueObjectInterface
{
    /**
     * @var numeric-string
     */
    private string $amount;

    public function __construct(string|int $amount)
    {
        $amount = (string) $amount;

        $this->validate($amount);

        /**
         * @var numeric-string $amount
         */
        $this->amount = $amount;
    }

    /**
     * @return numeric-string
     */
    #[\Override]
    public function value(): string
    {
        return $this->amount;
    }

    /**
     * @infection-ignore-all
     * Этот метод сравнивает значение через bccomp для учёта scale.
     * Мутант с `<=>` эквивалентен, но нарушает контракт точности.
     */
    public function isPositive(): bool
    {
        $scale = $this->extractScale();

        return bccomp($this->amount, '0', $scale) === 1;
    }

    /**
     * @infection-ignore-all
     *
     * Этот метод сравнивает значение через bccomp для учёта scale.
     * Мутант с `<=>` эквивалентен, но нарушает контракт точности.
     */
    public function isNegative(): bool
    {
        $scale = $this->extractScale();

        return bccomp($this->amount, '0', $scale) === -1;
    }

    /**
     * @infection-ignore-all
     *
     * Этот метод сравнивает значение через bccomp для учёта scale.
     * Мутант с `<=>` эквивалентен, но нарушает контракт точности.
     */
    public function isZero(): bool
    {
        $scale = $this->extractScale();

        return bccomp($this->amount, '0', $scale) === 0;
    }

    /**
     * @param  string  $amount
     * @return void
     * @throws InvalidAmountException
     */
    private function validate(string $amount): void
    {
        if (!preg_match('/^-?\d+(\.\d+)?$/', $amount)) {
            throw new InvalidAmountException('Amount must be numeric');
        }
    }

    private function extractScale(): int
    {
        if (stripos($this->amount, 'e') !== false) {
            throw new InvalidAmountException('Scientific notation is not allowed');
        }

        return strlen(explode('.', $this->amount)[1] ?? '');
    }
}
