<?php

declare(strict_types=1);

namespace Feedex\Tests\Http;

use Feedex\Coinex\v2\Http\Signer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SignerGoldenPayloadTest extends TestCase
{
    /**
     * @return iterable<string, array{method: string, path: string, body: string, timestamp: int, secret: string, expected: string}>
     */
    public static function goldenPayloads(): iterable
    {
        yield 'get-query-no-body' => [
            'method' => 'GET',
            'path' => '/v2/assets/spot/balance?ccy=USDT',
            'body' => '',
            'timestamp' => 1700000000000,
            'secret' => 'test-secret',
            'expected' => '0ae98f8e934908ae006b1a5e38a398756949d2c926e857cfab2b076c17b47c02',
        ];

        yield 'post-query-and-body' => [
            'method' => 'POST',
            'path' => '/v2/futures/order?market=BTCUSDT&side=buy',
            'body' => '{"amount":"1","price":"60000"}',
            'timestamp' => 1700000000123,
            'secret' => 'another-secret',
            'expected' => '7fafefc9db838fe7fd88be7278a9f55a3f00817a5b12061558a8b693e60bd6e5',
        ];

        yield 'post-encoded-query-and-slash-body' => [
            'method' => 'POST',
            'path' => '/v2/spot/order-status?market=BTC%2FUSDT&client_id=abc%20123',
            'body' => '{"foo":"bar/baz","x":1}',
            'timestamp' => 1700000000999,
            'secret' => 's3cr3t',
            'expected' => '1a9ef66f10aa4f1448b329924d48224b8d180e05974b65649e8cd4170c6141df',
        ];
    }

    #[DataProvider('goldenPayloads')]
    public function testSignerMatchesGoldenVector(
        string $method,
        string $path,
        string $body,
        int $timestamp,
        string $secret,
        string $expected
    ): void {
        self::assertSame($expected, Signer::sign($method, $path, $body, $timestamp, $secret));
    }
}
