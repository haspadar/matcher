<?php

declare(strict_types=1);

namespace Matcher\Tests\Payment\Domain\Service;

use Matcher\Payment\Domain\Entity\Cashout;
use Matcher\Payment\Domain\Event\CashoutCreatedEvent;
use Matcher\Payment\Domain\Repository\CashoutRepositoryInterface;
use Matcher\Payment\Domain\Service\CashoutService;
use Matcher\Payment\Domain\ValueObject\CardNumber;
use Matcher\Payment\Domain\ValueObject\PaymentCurrency;
use Matcher\Payment\Domain\ValueObject\PaymentProject;
use Matcher\Payment\Domain\ValueObject\Type;
use Matcher\Shared\Domain\ValueObject\PositiveAmount;
use Matcher\Shared\Domain\ValueObject\Url;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class CashoutServiceTest extends TestCase
{
    private MockObject $cashoutRepository;
    private MockObject $eventDispatcher;
    private CashoutService $cashoutService;

    #[Test]
    public function canCreateValidCashout(): void
    {
        $userId = 123;
        $cardNumber = new CardNumber('1234567890123456');
        $amount = new PositiveAmount(1000);
        $currency = new PaymentCurrency('USD', 100);
        $callbackUrl = new Url('https://example.com/callback');
        $type = Type::TEST;
        $project = new PaymentProject('some-project-code', true);
        $this->cashoutRepository
            ->expects(self::once())
            ->method('save')
            ->with(
                self::callback(function (Cashout $cashout) use ($userId, $cardNumber, $amount, $currency, $callbackUrl, $project, $type) {
                    return
                        $cashout->getUserId() === $userId &&
                        $cashout->getCardNumber()->value() === $cardNumber->value() &&
                        $cashout->getProject()->code === $project->code &&
                        $cashout->getAmount()->value() === $amount->value() &&
                        $cashout->getCurrency()->code === $currency->code &&
                        $cashout->getCallbackUrl()->value() === $callbackUrl->value() &&
                        $cashout->getType() === $type;
                }),
            );

        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(CashoutCreatedEvent::class));

        $cashout = $this->cashoutService->createCashout(
            $project,
            $userId,
            $cardNumber,
            $amount,
            $currency,
            $callbackUrl,
            $type
        );

        $this->assertInstanceOf(Cashout::class, $cashout);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->cashoutRepository = $this->createMock(CashoutRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->cashoutService = new CashoutService($this->cashoutRepository, $this->eventDispatcher);
    }
}
