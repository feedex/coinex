<?php

declare(strict_types=1);

namespace Feedex\Tests\Support;

use Feedex\Coinex\v2\Contracts\HttpClientInterface;

final class SpyHttpClient implements HttpClientInterface
{
    /** @var array<int, array{method: string, path: string, query: array<string, mixed>, body: array<string, mixed>, authenticated: bool}> */
    private array $calls = [];

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function request(
        string $method,
        string $path,
        array $query = [],
        array $body = [],
        bool $authenticated = true
    ): array {
        $this->calls[] = [
            'method' => $method,
            'path' => $path,
            'query' => $query,
            'body' => $body,
            'authenticated' => $authenticated,
        ];

        return [
            'code' => 0,
            'data' => [
                'ok' => true,
            ],
            'message' => 'OK',
        ];
    }

    /** @return array{method: string, path: string, query: array<string, mixed>, body: array<string, mixed>, authenticated: bool} */
    public function lastCall(): array
    {
        if ($this->calls === []) {
            throw new \RuntimeException('No HTTP calls recorded.');
        }

        $lastKey = array_key_last($this->calls);

        return $this->calls[$lastKey];
    }
}
