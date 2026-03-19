<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Coinex\v2\Contracts\HttpClientInterface;
use Feedex\Coinex\v2\Exceptions\CoinexRequestException;

abstract class Module
{
    public function __construct(protected readonly HttpClientInterface $httpClient)
    {
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    protected function publicGet(string $path, array $query = []): array
    {
        return $this->httpClient->request('GET', $path, $query, [], false);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    protected function privateGet(string $path, array $query = []): array
    {
        return $this->httpClient->request('GET', $path, $query);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    protected function privatePost(string $path, array $body = []): array
    {
        return $this->httpClient->request('POST', $path, [], $body);
    }
}
