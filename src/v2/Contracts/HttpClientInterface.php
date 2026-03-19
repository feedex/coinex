<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Contracts;

use Feedex\Coinex\v2\Exceptions\CoinexRequestException;

interface HttpClientInterface
{
    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    public function request(
        string $method,
        string $path,
        array $query = [],
        array $body = [],
        bool $authenticated = true
    ): array;
}
