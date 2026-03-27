<?php

declare(strict_types=1);

namespace Feedex\Tests\Http;

use Feedex\Coinex\v2\Exceptions\CoinexRateLimitException;
use Feedex\Coinex\v2\Http\CoinexHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class CoinexHttpClientRetryTest extends TestCase
{
    public function testRetriesOnRateLimitWhenEnabled(): void
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode(['code' => 1, 'message' => 'rate limit exceeded'], JSON_THROW_ON_ERROR)),
            new Response(200, [], json_encode(['code' => 0, 'data' => ['ok' => true], 'message' => 'OK'], JSON_THROW_ON_ERROR)),
        ]);

        $client = new Client([
            'base_uri' => 'https://api.coinex.com',
            'handler' => HandlerStack::create($mock),
        ]);

        $http = new CoinexHttpClient('id', 'secret', 'https://api.coinex.com', 60, 1, 1, 1.0, $client);

        $result = $http->request('GET', '/time', [], [], false);

        self::assertSame(0, $result['code']);
        self::assertSame(true, $result['data']['ok']);
    }

    public function testDoesNotRetryWhenDisabled(): void
    {
        $this->expectException(CoinexRateLimitException::class);

        $mock = new MockHandler([
            new Response(429, [], json_encode(['code' => 1, 'message' => 'rate limit exceeded'], JSON_THROW_ON_ERROR)),
        ]);

        $client = new Client([
            'base_uri' => 'https://api.coinex.com',
            'handler' => HandlerStack::create($mock),
        ]);

        $http = new CoinexHttpClient('id', 'secret', 'https://api.coinex.com', 60, 0, 1, 1.0, $client);
        $http->request('GET', '/time', [], [], false);
    }
}
