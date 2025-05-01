<?php

declare(strict_types=1);

namespace Matcher\Tests\Shared\Domain\Exception;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ErrorCodeTraitTest extends TestCase
{
    #[Test]
    public function codeReturnsCorrectErrorCode(): void
    {
        $example = new ErrorCodeExample();  // Создаем экземпляр класса, который использует трейт

        // Проверяем, что метод code() возвращает правильный код ошибки
        $this->assertSame('1234', $example->code());
    }
}
