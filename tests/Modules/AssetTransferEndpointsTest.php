<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\AssetTransfer;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AssetTransferEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new AssetTransfer($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => $httpMethod,
            'path' => $path,
            'query' => $httpMethod === 'GET' ? $args : [],
            'body' => $httpMethod === 'POST' ? $args : [],
            'authenticated' => true,
        ], $spy->lastCall());
    }

    /** @return iterable<string, array{string, array<string, mixed>, string, string}> */
    public static function endpointProvider(): iterable
    {
        yield 'transfer' => ['transfer', ['from' => 'spot', 'to' => 'margin'], 'POST', '/assets/transfer'];
        yield 'listTransferHistory' => ['listTransferHistory', ['ccy' => 'USDT'], 'GET', '/assets/transfer-history'];
    }
}
