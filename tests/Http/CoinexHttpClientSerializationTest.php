<?php

declare(strict_types=1);

namespace Feedex\Tests\Http;

use Feedex\Coinex\v2\Http\CoinexHttpClient;
use Feedex\Coinex\v2\Http\Signer;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class CoinexHttpClientSerializationTest extends TestCase
{
    public function testAuthenticatedRequestSerializesQueryBodyAndSignatureWithoutDuplicateQuery(): void
    {
        $history = new \ArrayObject();
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['code' => 0, 'data' => ['ok' => true], 'message' => 'OK'], JSON_THROW_ON_ERROR)),
        ]));
        $handler->push(Middleware::history($history));

        $client = new Client([
            'base_uri' => 'https://api.coinex.com',
            'handler' => $handler,
        ]);

        $timestamp = 1700000000123;
        $http = new CoinexHttpClient(
            'my-access-id',
            'my-secret',
            'https://api.coinex.com',
            60,
            0,
            100,
            2.0,
            $client,
            static fn (): int => $timestamp
        );

        $query = ['market' => 'BTC/USDT', 'client_id' => 'abc 123'];
        $body = ['note' => 'a/b', 'amount' => '1'];

        $http->request('POST', '/spot/order-status', $query, $body, true);

        self::assertTrue(isset($history[0]));

        $request = $history[0]['request'];
        $expectedQuery = 'market=BTC%2FUSDT&client_id=abc%20123';
        $expectedBody = '{"note":"a/b","amount":"1"}';
        $expectedPathForSign = '/v2/spot/order-status?' . $expectedQuery;
        $expectedSignature = Signer::sign('POST', $expectedPathForSign, $expectedBody, $timestamp, 'my-secret');

        self::assertSame('/v2/spot/order-status', $request->getUri()->getPath());
        self::assertSame($expectedQuery, $request->getUri()->getQuery());
        self::assertSame($expectedBody, (string) $request->getBody());
        self::assertSame('my-access-id', $request->getHeaderLine('X-COINEX-KEY'));
        self::assertSame((string) $timestamp, $request->getHeaderLine('X-COINEX-TIMESTAMP'));
        self::assertSame($expectedSignature, $request->getHeaderLine('X-COINEX-SIGN'));
    }

    public function testPublicRequestDoesNotSendAuthHeadersAndBodyWhenEmpty(): void
    {
        $history = new \ArrayObject();
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['code' => 0, 'data' => ['ok' => true], 'message' => 'OK'], JSON_THROW_ON_ERROR)),
        ]));
        $handler->push(Middleware::history($history));

        $client = new Client([
            'base_uri' => 'https://api.coinex.com',
            'handler' => $handler,
        ]);

        $http = new CoinexHttpClient('my-access-id', 'my-secret', 'https://api.coinex.com', 60, 0, 100, 2.0, $client);
        $http->request('GET', '/common/time', ['foo' => 'bar baz'], [], false);

        self::assertTrue(isset($history[0]));

        $request = $history[0]['request'];
        self::assertSame('/v2/common/time', $request->getUri()->getPath());
        self::assertSame('foo=bar%20baz', $request->getUri()->getQuery());
        self::assertSame('', $request->getBody()->getContents());
        self::assertSame('', $request->getHeaderLine('X-COINEX-KEY'));
        self::assertSame('', $request->getHeaderLine('X-COINEX-TIMESTAMP'));
        self::assertSame('', $request->getHeaderLine('X-COINEX-SIGN'));
        self::assertSame('', $request->getHeaderLine('Content-Type'));
    }
}
