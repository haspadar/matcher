<?php

declare(strict_types=1);

namespace Matcher\Shared\Domain\ValueObject;

use Matcher\Shared\Domain\Exception\InvalidUrlException;

final class Url implements ValueObjectInterface
{
    use ValueObjectEqualsTrait;

    private string $url;

    public function __construct(string $url)
    {
        $url = trim($url);
        $this->validate($url);
        $this->url = $url;
    }

    #[\Override]
    public function value(): string
    {
        return $this->url;
    }

    private function validate(string $url): void
    {
        if (!$url) {
            throw new InvalidUrlException('URL is required');
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException('Invalid URL format');
        }
    }
}
